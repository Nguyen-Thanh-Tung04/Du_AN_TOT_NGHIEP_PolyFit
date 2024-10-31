<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreCheckoutRequest;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Variant;
use App\Models\Voucher;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use App\Services\CheckoutService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Events\OrderPlaced;


class CheckoutController
{
    protected $userService;
    protected $checkoutService;
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        CheckoutService $checkoutService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
        $this->checkoutService = $checkoutService;
    }

    public function checkoutProcess(Request $request)
    {
        if ($request->isMethod('GET')) {
            // Chuyển hướng về trang giỏ hàng nếu người dùng truy cập bằng GET
            return redirect()->route('cart.index')->with('error', 'Không được phép truy cập khi chưa mua hàng.');
        }
    }

    public function showFormCheckout(Request $request)
    {
        $productVarians = $request->input('product_variant_ids');
        if (empty($productVarians)) {
            return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }

        $quantities = [];
        foreach ($productVarians as $id) {
            $quantities[$id] = $request->input("quantities.$id");
        }
        $productVariants = Variant::whereIn('id', $productVarians)->with('product', 'color', 'size')->get();

         // Kiểm tra số lượng từng sản phẩm so với số lượng trong kho
        foreach ($productVariants as $productVariant) {
            $requestedQuantity = $quantities[$productVariant->id];
            
            if ($productVariant->quantity < $requestedQuantity || $productVariant->quantity <= 0) { // Giả sử `quantity` là cột chứa số lượng hàng trong kho
                return redirect()->back()->with('error', 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.');
            }
        }

        $total = 0;
        $firstProduct = null;

        foreach ($productVariants as $productVariant) {
            $qty = $quantities[$productVariant->id];
            $total += ($productVariant->sale_price != 0) ? $productVariant->sale_price * $qty : $productVariant->listed_price * $qty;
            // lấy thông tin sản phẩm đầu tiên
            if (!$firstProduct) {
                $firstProduct = $productVariant->product;
            }
        }
        $userId = Auth::id();
        $user = $this->userRepository->findById($userId);
        $provinces = $this->provinceRepository->all();

        $selectedItems = session('selected_items', []);
        $cartItems = Cart::with('variant.product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedItems)
            ->get();

        $totalPrice = $this->checkoutService->calculateTotal($cartItems);
        return view('client.page.checkout', [
            'user' => $user,
            'provinces' => $provinces,
            'productVariants' => $productVariants,
            'quantities' => $quantities,
            'total' => $total,
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'product_name' => $firstProduct->name ?? 'Sản phẩm không xác định', // Tên sản phẩm đầu tiên
            'image' => $firstProduct->image ?? 'default-image.jpg' // Ảnh sản phẩm đầu tiên
        ]);
    }

    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $totalAmount = $request->input('total_amount');

        $voucher = Voucher::where('code', $voucherCode)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('min_order_value', '<=', $totalAmount)
            ->where('max_order_value', '>=', $totalAmount)
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ, đã hết hạn hoặc hết lượt sử dụng.'
            ]);
        }
        if ($voucher->start_time > now()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher này chưa có hiệu lực.'
            ]);
        }
        if ($voucher->end_time < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher này đã hết hạn, không thể sử dụng.'
            ]);
        }
        if ($voucher->min_order_value && $totalAmount < $voucher->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng của bạn không đủ giá trị tối thiểu để áp dụng mã voucher này.'
            ]);
        }

        if ($voucher->max_order_value && $totalAmount > $voucher->max_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng của bạn vượt mức số tiền cho phép để áp dụng mã voucher này.'
            ]);
        }

        // Tính toán giảm giá
        $discount = 0;
        if ($voucher->discount_type == 'percentage') {
            // Tính giảm giá theo phần trăm
            $discount = ($voucher->value / 100) * $totalAmount;

            // Kiểm tra nếu giảm giá vượt quá max_discount_value
            if ($voucher->max_discount_value && $discount > $voucher->max_discount_value) {
                $discount = $voucher->max_discount_value;
                $discount = floor($discount);
            }
        } elseif ($voucher->discount_type == 'fixed') {
            // Giảm giá theo số tiền cụ thể
            $discount = $voucher->value;

            // Đảm bảo không vượt quá tổng tiền đơn hàng
            if ($discount > $totalAmount) {
                $discount = $totalAmount;
            }
        }

        // Tính toán tổng tiền sau khi áp dụng giảm giá
        $finalTotal = $totalAmount - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công.',
            'discount' => $discount,
            'final_total' => $finalTotal,
            'voucher' => $voucher,
        ]);
    }

    public function getAvailableVouchers()
    {
        $availableVouchers = Voucher::where('status', 1)
            ->whereDate('start_time', '<=', now())
            ->whereDate('end_time', '>=', now())
            ->get();
        return response()->json([
            'success' => true,
            'vouchers' => $availableVouchers
        ]);
    }


    public function orderStore(StoreCheckoutRequest $request)
    {
        $totalAmount = $request->input('total_amount');
        $voucherCode = $request->input('voucher_code');
        $dateCode = date('Ymd');
        $randomNumberCode = mt_rand(10000000, 99999999);
        $code = '#SP-' . $dateCode . $randomNumberCode;

        $voucher = Voucher::where('code', $voucherCode)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('min_order_value', '<=', $totalAmount)
            ->where('max_order_value', '>=', $totalAmount)
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->first();

        if ($voucherCode) {
            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã voucher không hợp lệ, đã hết hạn hoặc hết lượt sử dụng.',
                ]);
            }
        }

        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'code' => $code,
            'voucher_id' => $voucher->id ?? null,
            'voucher_code' => $voucher->code ?? null,
            'full_name' => $request->input('full_name'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'ward_id' => $request->input('ward_id'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'note' => $request->input('note') ?? null,
            'shipping_cost' => $request->input('shipping_cost'),
            'total_price' => $request->input('final_total'),
            'discount_amount' => $request->input('discount_amount'),
            'payment_method' => $request->input('payment_method'),
        ]);

        $productVariants = $request->input('product_variants');
        $productVariantIds = []; // Mảng lưu trữ ID của các biến thể sản phẩm đã đặt hàng

        foreach ($productVariants as $variant) {
            // Tìm kiếm biến thể sản phẩm
            $productVariant = Variant::find($variant['product_variant_id']);

            // Kiểm tra nếu biến thể tồn tại và số lượng đủ
            if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
                // Tạo bản ghi OrderItem
                OrderItem::create([
                    'order_id' => $order->id,
                    'variant_id' => $variant['product_variant_id'],
                    'image' => $variant['image'],
                    'price' => $variant['price'],
                    'color' => $variant['color'],
                    'size' => $variant['size'],
                    'quantity' => $variant['quantity'],
                ]);
                // Trừ số lượng sản phẩm
                $productVariant->decrement('quantity', $variant['quantity']);

                // Thêm ID của biến thể vào mảng
                $productVariantIds[] = $variant['product_variant_id'];
            } else {
                // Xử lý trường hợp không đủ số lượng sản phẩm
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không đủ số lượng: ' . $variant['product_variant_id'],
                ], 400);
            }
        }
        // Sau khi đơn hàng được tạo, phát sự kiện realtime
        // event(new OrderPlaced($order));

        if ($voucher) {
            if ($voucher->quantity > 0) {
                $voucher->decrement('quantity', 1); // Trừ số lượng voucher nếu có cột quantity
            }
        }

        // Xóa những sản phẩm đã được chọn mua trong giỏ hàng
        Cart::where('user_id', $user->id)
            ->whereIn('variant_id', $productVariantIds) // Giả định rằng bạn có cột variant_id trong bảng giỏ hàng
            ->delete(); // Xóa các sản phẩm trong giỏ hàng tương ứng
        //Send Mail
        Mail::to($user->email)->queue(new OrderPlacedMail($order));

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'message' => 'Đặt hàng thành công!',
        ]);
    }

    public function orderShow($id)
    {
        $order = Order::with('orderItems.variant')->findOrFail($id);

        return view('client.page.order', compact([
            'order',
        ]));
    }

    public function vnpayPayment(StoreCheckoutRequest $request)
    {
        $data = $request->all(); // Lấy tất cả dữ liệu từ form checkout
        session()->put('checkout_data', $data);
        $checkoutData = session()->get('checkout_data');

        $voucher = Voucher::where('code', $checkoutData['voucher_code'])
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('min_order_value', '<=', $checkoutData['total_amount'])
            ->where('max_order_value', '>=', $checkoutData['total_amount'])
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->first();

        if ($request->input('voucher_code')) {
            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã voucher không hợp lệ, đã hết hạn hoặc hết lượt sử dụng.',
                ]);
            }
        }

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "QAZ9JCE2"; //Mã website tại VNPAY 
        $vnp_HashSecret = "M2B6JJ8UT7G5Z3AX737YGFBAV026H5OW"; //Chuỗi bí mật

        $dateCode = date('Ymd');
        $randomNumberCode = mt_rand(10000000, 99999999);
        $code = 'SP-' . $dateCode . $randomNumberCode;

        $vnp_TxnRef = $code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'other';
        $vnp_Amount = $request->input('final_total') * 100;
        $vnp_Locale = 'vn';
        // $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json([
            'success' => true,
            'code' => '00',
            'message' => 'success',
            'vnpay_url' => $vnp_Url
        ]);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momoPayment(StoreCheckoutRequest $request)
    {
        $data = $request->all(); // Lấy tất cả dữ liệu từ form checkout
        session()->put('checkout_data', $data);
        $checkoutData = session()->get('checkout_data');

        $voucher = Voucher::where('code', $checkoutData['voucher_code'])
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('min_order_value', '<=', $checkoutData['total_amount'])
            ->where('max_order_value', '>=', $checkoutData['total_amount'])
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->first();

        if ($request->input('voucher_code')) {
            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã voucher không hợp lệ, đã hết hạn hoặc hết lượt sử dụng.',
                ]);
            }
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $dateOrderId = date('Ymd');
        $randomNumberOrderId = mt_rand(10000000, 99999999);

        $amount = $request->input('final_total');
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua ATM MoMo";
        $orderId = 'SP-' . $dateOrderId . $randomNumberOrderId . "";
        $redirectUrl = route('vnpay.return');
        $ipnUrl = route('vnpay.return');

        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return response()->json([
            'success' => true,
            'message' => 'success',
            'momo_url' => $jsonResult['payUrl']
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode') ?? $request->input('resultCode'); // Mã phản hồi của VNPAY
        if ($vnp_ResponseCode == '00' || $vnp_ResponseCode == '0') {
            $checkoutData = session()->get('checkout_data');

            $user = Auth::user();
            $voucher = Voucher::where('code', $checkoutData['voucher_code'])
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->where('min_order_value', '<=', $checkoutData['total_amount'])
                ->where('max_order_value', '>=', $checkoutData['total_amount'])
                ->where('quantity', '>', 0)
                ->where('status', 1)
                ->first();

            $order = Order::create([
                'user_id' => $user->id,
                'code' => $request->input('vnp_TxnRef') ?? $request->input('orderId'),
                'voucher_id' => $voucher->id ?? null,
                'voucher_code' => $checkoutData['voucher_code'] ?? null,
                'full_name' => $checkoutData['full_name'],
                'province_id' => $checkoutData['province_id'],
                'district_id' => $checkoutData['district_id'],
                'ward_id' => $checkoutData['ward_id'],
                'address' => $checkoutData['address'],
                'phone' => $checkoutData['phone'],
                'note' => $checkoutData['note'] ?? null,
                'shipping_cost' => $checkoutData['shipping_cost'],
                'total_price' => $checkoutData['final_total'],
                'discount_amount' => $checkoutData['discount_amount'],
                'payment_method' => $checkoutData['payment_method'],
            ]);

            $productVariantIds = []; // Mảng lưu trữ ID của các biến thể sản phẩm đã đặt hàng

            foreach ($checkoutData['product_variants'] as $variant) {
                // Tìm kiếm biến thể sản phẩm
                $productVariant = Variant::find($variant['product_variant_id']);

                // Kiểm tra nếu biến thể tồn tại và số lượng đủ
                if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
                    // Tạo bản ghi OrderItem
                    OrderItem::create([
                        'order_id' => $order->id,
                        'variant_id' => $variant['product_variant_id'],
                        'image' => $variant['image'],
                        'price' => $variant['price'],
                        'color' => $variant['color'],
                        'size' => $variant['size'],
                        'quantity' => $variant['quantity'],
                    ]);

                    // Trừ số lượng sản phẩm
                    $productVariant->decrement('quantity', $variant['quantity']);

                    // Thêm ID của biến thể vào mảng
                    $productVariantIds[] = $variant['product_variant_id'];
                } else {
                    // Xử lý trường hợp không đủ số lượng sản phẩm
                    return response()->json([
                        'success' => false,
                        'message' => 'Sản phẩm không đủ số lượng: ' . $variant['product_variant_id'],
                    ], 400);
                }
            }
            // Sau khi đơn hàng được tạo, phát sự kiện realtime
            // event(new OrderPlaced($order));

            // Trừ số lượng hoặc số lần sử dụng của voucher (nếu voucher tồn tại và có cột để quản lý số lượng)
            if ($voucher) {
                // Giả sử bạn có cột `quantity` để quản lý số lượng hoặc `uses` để đếm số lần sử dụng voucher
                if ($voucher->quantity > 0) {
                    $voucher->decrement('quantity', 1); // Trừ số lượng voucher nếu có cột quantity
                } //  elseif ($voucher->uses > 0) {
                //     $voucher->decrement('uses', 1); // Trừ số lần sử dụng voucher nếu có cột uses
                // }
            }

            // Xóa những sản phẩm đã được chọn mua trong giỏ hàng
            Cart::where('user_id', $user->id)
                ->whereIn('variant_id', $productVariantIds) // Giả định rằng bạn có cột variant_id trong bảng giỏ hàng
                ->delete(); // Xóa các sản phẩm trong giỏ hàng tương ứng

            //Send Mail
            Mail::to($user->email)->queue(new OrderPlacedMail($order));

            // Xóa thông tin trong session
            session()->forget('checkout_data');

            // Sau khi đơn hàng được tạo, phát sự kiện realtime
            event(new OrderPlaced($order));


            // Chuyển hướng đến trang bill với thông tin đơn hàng
            return redirect()->route('order.show', $order->id);
        } else {
            // Thanh toán thất bại
            return redirect()->route('cart.index')->with('error', 'Thanh toán không thành công.');
        }
    }
}