<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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

        return view('client.page.checkout', compact(
            'user',
            'provinces',
            'productVariants',
            'quantities',
            'total',
        ));
    }

    public function applyVoucher(Request $request)
{
    $voucherCode = $request->input('voucher_code');
    $totalAmount = $request->input('total_amount');
   
    $voucher = Voucher::where('code', $voucherCode)
    ->where('status', 1)
    ->whereDate('start_time', '<=', now())
    ->whereDate('end_time', '>=', now())
    ->first();
    
    if (!$voucher) {
        return response()->json([
            'success' => false, 
            'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn.'
        ]);
    }
    if ($voucher->min_order_value && $totalAmount < $voucher->min_order_value) {
        return response()->json([
            'success' => false,
            'message' => 'Đơn hàng của bạn không đủ giá trị tối thiểu để áp dụng mã voucher này.'
        ]);
    } elseif ($voucher->min_order_value && $totalAmount > $voucher->max_discount_value) {
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


    public function orderStore(Request $request) {
        $totalAmount = $request->input('total_amount');
        $voucherCode = $request->input('voucher_code');

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
        foreach ($productVariants as $variant) {
            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $variant['product_variant_id'],
                'image' => $variant['image'],
                'price' => $variant['price'],
                'color' => $variant['color'],
                'size' => $variant['size'],
                'quantity' => $variant['quantity'],
            ]);
        }

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
}
