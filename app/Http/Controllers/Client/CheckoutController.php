<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderPlaced;
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
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Integer;

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
        if (Session::has('product_variants')) {
            $data = Session::get('product_variants');

            if (empty($data)) {
                return redirect()->back()->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
            }

            $existingVariants = Variant::whereIn('id', $data['product_variant_ids'])->pluck('id')->all();
            $nonExistingVariants = array_diff($data['product_variant_ids'], $existingVariants);
            if (!empty($nonExistingVariants)) {
                return redirect()->back()->with('error', 'Thuộc tính sản phẩm không tồn tại.');
            }

            $quantities = [];
            foreach ($data['product_variant_ids'] as $id) {
                $quantities[$id] = $data["quantities"][$id];
            }
            $productVariants = Variant::whereIn('id', $data['product_variant_ids'])->with('product', 'color', 'size')->get();

            // Kiểm tra số lượng từng sản phẩm so với số lượng trong kho
            foreach ($productVariants as $productVariant) {
                $requestedQuantity = $quantities[$productVariant->id];

                if ($productVariant->quantity < $requestedQuantity || $productVariant->quantity <= 0) {
                    return redirect()->back()->with('error', 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.');
                }
            }

            $total = 0;
            $firstProduct = null;

            foreach ($productVariants as $productVariant) {
                $qty = $quantities[$productVariant->id];
                // lấy thông tin sản phẩm đầu tiên
                if (!$firstProduct) {
                    $firstProduct = $productVariant->product;
                }

                $flashSaleProduct = $productVariant->product->flashSaleProducts()->where('variant_id', $productVariant->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('status', 1)
                            ->where('date', now()->toDateString())
                            ->where(function ($query) {
                                $currentHour = now()->hour;
                                $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour]) // Giờ bắt đầu <= giờ hiện tại
                                    ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]); // Giờ kết thúc > giờ hiện tại
                            });
                    })
                    ->where('status', 1)
                    ->where('quantity', '>', 0)
                    ->first();

                if ($flashSaleProduct) {
                    $flashSaleQty = min($qty, $flashSaleProduct->quantity);
                    $normalQty = $qty - $flashSaleQty;
                    $productVariant->setAttribute('new_price', $flashSaleProduct->flash_price);
                    $productVariant->setAttribute('normal_price', $flashSaleProduct->listed_price);
                    $total += $flashSaleProduct->flash_price * $flashSaleQty;
                    $total += ($productVariant->sale_price != 0 ? $productVariant->sale_price : $productVariant->listed_price) * $normalQty;
                } else {
                    $total += ($productVariant->sale_price != 0) ? $productVariant->sale_price * $qty : $productVariant->listed_price * $qty;
                    $productVariant->setAttribute('new_price', $productVariant->sale_price  ?? null);
                    $productVariant->setAttribute('normal_price', $productVariant->listed_price);
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
        // else {
        //     // Xử lý khi không có dữ liệu trong session (ví dụ: chuyển hướng đến trang khác hoặc hiển thị thông báo lỗi)
        //     return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm khi tiến hành mua hàng.');
        // }
    }

    public function showFormCheckout(Request $request)
    {
        if ($request->has('product_variant_ids')) {
            $cartItems = Cart::where('user_id', auth()->id())
                ->with('variant.product') // Tải mối quan hệ từ Cart -> Variant -> Product
                ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Sản phẩm không còn tồn tại.');
            }
    
            foreach ($cartItems as $item) {
                if ($item->variant->product->status == 2) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm không còn bán.');
                }
                if ($item->quantity <= 0) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm đã hết hàng.');
                }
            }
            $data = $request->all();
            Session::put('product_variants', $data);

            // Chuyển hướng đến route 'checkout' với phương thức GET
            return redirect()->route('checkout.process');
        } else {
            return redirect()->route('cart.index')->with('error', 'Chưa chọn sản phẩm.');
        }
    }

    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $totalAmount = $request->input('total_amount');

        $voucher = Voucher::where('code', $voucherCode)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            
            ->where('quantity', '>', 0)
            ->where('status', 1)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ, đã hết hạn hoặc hết lượt sử dụng.'
            ]);
        }



        // Kiểm tra thời gian sử dụng voucher
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

        // Kiểm tra giá trị đơn hàng và các điều kiện khác (min_order_value, max_order_value)
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
            // Giảm giá theo phần trăm
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
        $totalAmount = 0;
        $productVariants = $request->input('product_variants');
        $productVariantIds = [];

        foreach ($productVariants as $variant) {
            $productVariant = Variant::where('id', $variant['product_variant_id'])
            ->with('product')
            ->first();

            if ($productVariant && $productVariant->product->status == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                ], 400);
            }

            if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
                $flashSaleProduct = $productVariant->product->flashSaleProducts()
                    ->where('variant_id', $productVariant->id)
                    ->whereHas('flashSale', function ($query) {
                        $query->where('status', 1)
                            ->where('date', now()->toDateString())
                            ->where(function ($query) {
                                $currentHour = now()->hour;
                                $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour])
                                    ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]);
                            });
                    })
                    ->where('status', 1)
                    ->where('quantity', '>', 0)
                    ->first();

                $flashSaleQty = 0;
                $normalQty = $variant['quantity'];
                $flashSalePrice = 0;
                $normalPrice = $productVariant->sale_price ?? $productVariant->listed_price;
                if ($flashSaleProduct) {
                    $flashSaleQty = min($variant['quantity'], $flashSaleProduct->quantity);
                    $normalQty = $variant['quantity'] - $flashSaleQty;
                    $flashSalePrice = $flashSaleProduct->flash_price;
                }

                $totalAmount += ($flashSalePrice * $flashSaleQty) + ($normalPrice * $normalQty);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                ], 400);
            }
        }

        $voucherCode = $request->input('voucher_code');
        $dateCode = date('Ymd');
        $randomNumberCode = mt_rand(10000000, 99999999);
        $code = '#SP-' . $dateCode . $randomNumberCode;

        $voucher = Voucher::where('code', $voucherCode)
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            
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
        // Kiểm tra nếu người dùng đã sử dụng voucher này



        $user = Auth::user();
        if($voucher != null) {
            if ( $voucher->users()->where('user_id', $user->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã sử dụng voucher này trước đó.'
                ]);
            }
            $voucher->users()->attach($user->id, ['used_at' => now()]);
        }
        
        $lastOrder = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();

        if ($lastOrder && $lastOrder->created_at->diffInSeconds(now()) < 10) {
            return redirect()->back();
        }

        if ($request->input('discount_amount')) {
            $totalAmount = ($totalAmount + $request->input('shipping_cost')) - $request->input('discount_amount');
        } else {
            $totalAmount = ($totalAmount + $request->input('shipping_cost'));
        }

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
            'shipping_cost' => (int)$request->input('shipping_cost'),
            'total_price' => $totalAmount,
            'discount_amount' => $request->input('discount_amount'),
            'payment_method' => (int)$request->input('payment_method'),
        ]);

        foreach ($productVariants as $variant) {
            $productVariant = Variant::where('id', $variant['product_variant_id'])
            ->with('product')
            ->first();

            if ($productVariant && $productVariant->product->status == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                ], 400);
            }

            $flashSaleProduct = $productVariant->product->flashSaleProducts()
                ->where('variant_id', $productVariant->id)
                ->whereHas('flashSale', function ($query) {
                    $query->where('status', 1)
                        ->where('date', now()->toDateString())
                        ->where(function ($query) {
                            $currentHour = now()->hour;
                            $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour])
                                ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]);
                        });
                })
                ->where('status', 1)
                ->where('quantity', '>', 0)
                ->first();

            $flashSaleQty = 0;
            $normalQty = $variant['quantity'];
            $flashSalePrice = 0;
            $normalPrice = $productVariant->sale_price ?? $productVariant->listed_price;

            if ($flashSaleProduct) {
                $flashSaleQty = min($variant['quantity'], $flashSaleProduct->quantity);
                $normalQty = $variant['quantity'] - $flashSaleQty;
                $flashSalePrice = $flashSaleProduct->flash_price;
            }

            if ($flashSaleQty > 0) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'name' => $variant['name'],
                    'variant_id' => $variant['product_variant_id'],
                    'price' => $flashSalePrice,
                    'quantity' => $flashSaleQty,
                    'image' => $variant['image'],
                    'color' => $variant['color'],
                    'size' => $variant['size'],
                ]);
                $flashSaleProduct->decrement('quantity', $flashSaleQty);
            }

            if ($normalQty > 0) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'name' => $variant['name'],
                    'variant_id' => $variant['product_variant_id'],
                    'price' => $normalPrice,
                    'quantity' => $normalQty,
                    'image' => $variant['image'],
                    'color' => $variant['color'],
                    'size' => $variant['size'],
                ]);
            }

            $productVariant->decrement('quantity', $variant['quantity']);
            $productVariantIds[] = $variant['product_variant_id'];
        }
        // Sau khi đơn hàng được tạo, phát sự kiện realtime
        event(new OrderPlaced($order));

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

        $productVariants = $request->input('product_variants');

        foreach ($productVariants as $variant) {
            $productVariant = Variant::where('id', $variant['product_variant_id'])
            ->with('product')
            ->first();

            if ($productVariant && $productVariant->product->status == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                ], 400);
            }

            if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
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
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.',
                ], 400);
            }
        }
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
        $productVariants = $request->input('product_variants');

        foreach ($productVariants as $variant) {
            $productVariant = Variant::where('id', $variant['product_variant_id'])
            ->with('product')
            ->first();

            if ($productVariant && $productVariant->product->status == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                ], 400);
            }

            if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
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
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.',
                ], 400);
            }
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode') ?? $request->input('resultCode'); // Mã phản hồi của VNPAY
        if ($vnp_ResponseCode == '00' || $vnp_ResponseCode == '0') {
            $checkoutData = session()->get('checkout_data');

            if ($checkoutData != null) {
                $productVariants = $checkoutData['product_variants'];

                // Calculate total amount
                $totalAmount = 0;
                foreach ($productVariants as $variant) {
                    $productVariant = Variant::where('id', $variant['product_variant_id'])
                    ->with('product')
                    ->first();
                    
                    if ($productVariant && $productVariant->product->status == 2) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                        ], 400);
                    }
    
                    if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
                        $flashSaleProduct = $productVariant->product->flashSaleProducts()
                            ->where('variant_id', $productVariant->id)
                            ->whereHas('flashSale', function ($query) {
                                $query->where('status', 1)
                                    ->where('date', now()->toDateString())
                                    ->where(function ($query) {
                                        $currentHour = now()->hour;
                                        $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour])
                                            ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]);
                                    });
                            })
                            ->where('status', 1)
                            ->where('quantity', '>', 0)
                            ->first();

                        $flashSaleQty = 0;
                        $normalQty = $variant['quantity'];
                        $flashSalePrice = 0;
                        $normalPrice = $productVariant->sale_price ?? $productVariant->listed_price;

                        if ($flashSaleProduct) {
                            $flashSaleQty = min($variant['quantity'], $flashSaleProduct->quantity);
                            $normalQty = $variant['quantity'] - $flashSaleQty;
                            $flashSalePrice = $flashSaleProduct->flash_price;
                        }

                        // Kiểm tra nếu sản phẩm hết hàng (số lượng <= 0)
                        if ($flashSaleQty == 0 && $normalQty == 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.',
                            ], 400);
                        }

                        $totalAmount += ($flashSalePrice * $flashSaleQty) + ($normalPrice * $normalQty);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' =>'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                        ], 400);
                    }
                }

                $user = Auth::user();
                $voucher = Voucher::where('code',  $checkoutData['voucher_code'])
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->where('quantity', '>', 0)
                    ->where('status', 1)
                    ->first();

                $order = Order::create([
                    'user_id' => $user->id,
                    'code' => $request->input('vnp_TxnRef') ?? $request->input('orderId'),
                    'voucher_id' => $voucher->id ?? null,
                    'voucher_code' => $voucherCode ?? null,
                    'full_name' => $checkoutData['full_name'],
                    'province_id' => $checkoutData['province_id'],
                    'district_id' => $checkoutData['district_id'],
                    'ward_id' => $checkoutData['ward_id'],
                    'address' => $checkoutData['address'],
                    'phone' => $checkoutData['phone'],
                    'note' => $checkoutData['note'] ?? null,
                    'shipping_cost' => $checkoutData['shipping_cost'],
                    'total_price' => $totalAmount + $checkoutData['shipping_cost'],
                    'discount_amount' => $checkoutData['discount_amount'],
                    'payment_method' => $checkoutData['payment_method'],
                ]);

                // Create order items
                $productVariantIds = [];
                foreach ($productVariants as $variant) {
                    $productVariant = Variant::where('id', $variant['product_variant_id'])
                    ->with('product')
                    ->first();
                    
                    if ($productVariant && $productVariant->product->status == 2) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sản phẩm "'.$productVariant->product->name.'" đã hết hàng.',
                        ], 400);
                    }
    
                    if ($productVariant && $productVariant->quantity >= $variant['quantity']) {
                        $flashSaleProduct = $productVariant->product->flashSaleProducts()
                            ->where('variant_id', $productVariant->id)
                            ->whereHas('flashSale', function ($query) {
                                $query->where('status', 1)
                                    ->where('date', now()->toDateString())
                                    ->where(function ($query) {
                                        $currentHour = now()->hour;
                                        $query->whereRaw('SUBSTRING_INDEX(time_slot, "-", 1) <= ?', [$currentHour])
                                            ->whereRaw('SUBSTRING_INDEX(time_slot, "-", -1) > ?', [$currentHour]);
                                    });
                            })
                            ->where('status', 1)
                            ->where('quantity', '>', 0)
                            ->first();

                        $flashSaleQty = 0;
                        $normalQty = $variant['quantity'];
                        $flashSalePrice = 0;
                        $normalPrice = $productVariant->sale_price ?? $productVariant->listed_price;

                        if ($flashSaleProduct) {
                            $flashSaleQty = min($variant['quantity'], $flashSaleProduct->quantity);
                            $normalQty = $variant['quantity'] - $flashSaleQty;
                            $flashSalePrice = $flashSaleProduct->flash_price;
                        }

                        if ($flashSaleQty > 0) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'name' => $variant['name'],
                                'variant_id' => $variant['product_variant_id'],
                                'price' => $normalPrice,
                                'quantity' => $normalQty,
                                'image' => $variant['image'],
                                'color' => $variant['color'],
                                'size' => $variant['size'],
                            ]);
                            $flashSaleProduct->decrement('quantity', $flashSaleQty);
                        }

                        if ($normalQty > 0) {
                            OrderItem::create([
                                'order_id' => $order->id,
                                'name' => $variant['name'],
                                'variant_id' => $variant['product_variant_id'],
                                'price' => $normalPrice,
                                'quantity' => $normalQty,
                                'image' => $variant['image'],
                                'color' => $variant['color'],
                                'size' => $variant['size'],
                            ]);
                        }

                        $productVariant->decrement('quantity', $variant['quantity']);
                        $productVariantIds[] = $variant['product_variant_id'];
                        Session::forget('product_variants');
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Sản phẩm "' . $productVariant->product->name . '" đã hết hàng.',
                        ], 400);
                    }
                }
                // Sau khi đơn hàng được tạo, phát sự kiện realtime
                event(new OrderPlaced($order));

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
                return redirect()->route('order.show', $order->id)->with('success', 'Thanh toán thành công.');
            } else {
                return redirect()->route('cart.index')->with('error', 'Thanh toán không thành công vì có sản phẩm đã hết số lượng.');
            }
        } else {
            // Thanh toán thất bại
            return redirect()->route('cart.index')->with('error', 'Thanh toán không thành công.');
        }
    }
}