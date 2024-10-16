<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Voucher;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use App\Services\CheckoutService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function showFormCheckout(Request $request) {
        $productVarians = $request->input('product_variant_ids');
        if (empty($productVarians)) {
            return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
        }
        
        $quantities = [];
        foreach ($productVarians as $id) {
            $quantities[$id] = $request->input("quantities.$id");
        }
        $productVariants = Variant::whereIn('id', $productVarians)->with('product', 'color', 'size')->get();

        $total = 0;
        foreach ($productVariants as $productVariant) {
            $qty = $quantities[$productVariant->id];
            $total += ($productVariant->sale_price != 0) ? $productVariant->sale_price * $qty : $productVariant->listed_price * $qty;
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
        return view('client.page.checkout', compact(
            'user',
            'provinces',
            'productVariants',
            'quantities',
            'total',
            'cartItems',
            'totalPrice'
        ));
    }
    // session()->forget('selected_items'); xóa khi order xong

    public function applyVoucher(Request $request)
{
    $voucherCode = $request->input('voucher_code');
    $totalAmount = $request->input('total_amount');
   
    $voucher = Voucher::where('code', $voucherCode)
    ->where('status', 1)
    ->where('start_time', '<=', now())
    ->where('end_time', '>=', now())
    ->first();
    
    if (!$voucher) {
        return response()->json([
            'success' => false, 
            'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn.'
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

    if ($voucher->max_discount_value && $totalAmount > $voucher->max_discount_value) {
        return response()->json([
            'success' => false,
            'message' => 'Đơn hàng của bạn vượt mức số tiền cho phép để áp dụng mã voucher này.'
        ]);
    }
    
    $discount = 0;
    if ($voucher->discount_type == 'percentage') {
        // Tính giảm giá theo phần trăm
        $discount = ($voucher->value / 100) * $totalAmount;
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


    public function orderStore(StoreCheckoutRequest $request) {
        $totalAmount = $request->input('total_amount');
        $voucherCode = $request->input('voucher_code');
        $dateCode = date('Ymd');
        $randomNumberCode = mt_rand(10000000, 99999999);
        $code = '#SP-' . $dateCode . $randomNumberCode;

        $voucher = Voucher::where('code', $voucherCode)
        ->where('start_time', '<=', now())
        ->where('end_time', '>=', now())
        ->where('min_order_value', '<=', $totalAmount)
        ->where('max_discount_value', '>=', $totalAmount)
        ->where('status', 1)
        ->first();
        
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

         // Trừ số lượng hoặc số lần sử dụng của voucher (nếu voucher tồn tại và có cột để quản lý số lượng)
        if ($voucher) {
            // Giả sử bạn có cột `quantity` để quản lý số lượng hoặc `uses` để đếm số lần sử dụng voucher
            if ($voucher->quantity > 0) {
                $voucher->decrement('quantity', 1); // Trừ số lượng voucher nếu có cột quantity
            }//  elseif ($voucher->uses > 0) {
            //     $voucher->decrement('uses', 1); // Trừ số lần sử dụng voucher nếu có cột uses
            // }
        }

        // Xóa những sản phẩm đã được chọn mua trong giỏ hàng
        Cart::where('user_id', $user->id)
            ->whereIn('variant_id', $productVariantIds) // Giả định rằng bạn có cột variant_id trong bảng giỏ hàng
            ->delete(); // Xóa các sản phẩm trong giỏ hàng tương ứng

        return response()->json([
            'success' => true, 
            'order_id' => $order->id,
            'message' => 'Đặt hàng thành công!',
        ]);

    }

    public function orderShow($id) {
        $order = Order::with('orderItems.variant')->findOrFail($id);

        return view('client.page.order', compact([
            'order',
        ]));
    }

    public function vnpayPayment(Request $request)
    {
        $data = $request->all(); // Lấy tất cả dữ liệu từ form checkout
        session()->put('checkout_data', $data);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "QAZ9JCE2";//Mã website tại VNPAY 
        $vnp_HashSecret = "M2B6JJ8UT7G5Z3AX737YGFBAV026H5OW"; //Chuỗi bí mật

        $dateCode = date('Ymd');
        $randomNumberCode = mt_rand(10000000, 99999999);
        $code = '#SP-' . $dateCode . $randomNumberCode;

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
            'a' => session()->get('checkout_data'),
            'vnpay_url' => $vnp_Url
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode'); // Mã phản hồi của VNPAY
        if ($vnp_ResponseCode == '00') {
            $checkoutData = session()->get('checkout_data');
            
            $user = Auth::user();
            $voucher = Voucher::where('code', $checkoutData['voucher_code'])
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('min_order_value', '<=', $checkoutData['total_amount'])
            ->where('max_discount_value', '>=', $checkoutData['total_amount'])
            ->where('status', 1)
            ->first();
            
            $order = Order::create([
                'user_id' => $user->id,
                'code' => $request->input('vnp_TxnRef'),
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

            // Trừ số lượng hoặc số lần sử dụng của voucher (nếu voucher tồn tại và có cột để quản lý số lượng)
            if ($voucher) {
                // Giả sử bạn có cột `quantity` để quản lý số lượng hoặc `uses` để đếm số lần sử dụng voucher
                if ($voucher->quantity > 0) {
                    $voucher->decrement('quantity', 1); // Trừ số lượng voucher nếu có cột quantity
                }//  elseif ($voucher->uses > 0) {
                //     $voucher->decrement('uses', 1); // Trừ số lần sử dụng voucher nếu có cột uses
                // }
            }

            // Xóa những sản phẩm đã được chọn mua trong giỏ hàng
            Cart::where('user_id', $user->id)
                ->whereIn('variant_id', $productVariantIds) // Giả định rằng bạn có cột variant_id trong bảng giỏ hàng
                ->delete(); // Xóa các sản phẩm trong giỏ hàng tương ứng
    
            // Xóa thông tin trong session
            session()->forget('checkout_data');
    
            // Chuyển hướng đến trang bill với thông tin đơn hàng
            return redirect()->route('order.show', $order->id);
        } else {
            // Thanh toán thất bại
            return redirect()->route('cart.index')->with('error', 'Thanh toán không thành công.');
        }
    }
}
