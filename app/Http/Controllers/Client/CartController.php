<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('variant.product', 'variant.color', 'variant.size')
            ->where('user_id', Auth::id())
            ->get();

        foreach ($cartItems as $item) {
            $product = $item->variant->product;
            $variant = $item->variant;

            // Kiểm tra xem variant có trong chương trình flash sale đang diễn ra hay không
            $flashSaleProduct = $product->flashSaleProducts()->where('variant_id', $variant->id)
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
                $flashSaleQty = min($item->quantity, $flashSaleProduct->quantity);
                $normalQty = $item->quantity - $flashSaleQty;

                $item->setAttribute('flash_sale_price', $flashSaleProduct->flash_price);
                $item->setAttribute('flash_sale_qty', $flashSaleQty);
                $item->setAttribute('normal_price', $variant->sale_price ?? $variant->listed_price);
                $item->setAttribute('normal_qty', $normalQty);
                $item->setAttribute('listed_price', $flashSaleProduct->listed_price);
            } else {
                $item->setAttribute('flash_sale_price', null);
                $item->setAttribute('flash_sale_qty', 0);
                $item->setAttribute('normal_price', $variant->sale_price ?? $variant->listed_price);
                $item->setAttribute('normal_qty', $item->quantity);
                $item->setAttribute('listed_price', $variant->listed_price);
            }
        }

        return view('client.page.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'color_id' => 'nullable|integer|exists:colors,id',
                'size_id' => 'nullable|integer|exists:sizes,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Dữ liệu không hợp lệ'
                ]);
            }

            if (!$request->color_id && !$request->size_id) {
                $variant = Variant::where('product_id', $request->product_id)
                    ->where('quantity', '>', 0)
                    ->first();
            } else {
                $variant = Variant::where('product_id', $request->product_id)
                    ->when($request->color_id, function ($query) use ($request) {
                        return $query->where('color_id', $request->color_id);
                    })
                    ->when($request->size_id, function ($query) use ($request) {
                        return $query->where('size_id', $request->size_id);
                    })
                    ->where('quantity', '>', 0)
                    ->first();
            }

            if (!$variant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Thuộc tính không hợp lệ'
                ], 400);
            }

            if ($request->quantity > $variant->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => "Hiện tại, chỉ còn {$variant->quantity} sản phẩm có sẵn. Vui lòng chọn số lượng ít hơn."
                ]);
            }

            $cartItem = Cart::where('user_id', Auth::id())
                ->where('variant_id', $variant->id)
                ->first();

            if ($cartItem) {
                if ($cartItem->quantity + $request->quantity > $variant->quantity) {
                    return response()->json([
                        'status' => false,
                        'message' => "Hiện tại, chỉ còn {$variant->quantity} sản phẩm có sẵn. Vui lòng chọn số lượng ít hơn."
                    ]);
                }
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                $cartItem = Cart::create([
                    'user_id' => Auth::id(),
                    'variant_id' => $variant->id,
                    'quantity' => $request->quantity,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
                'data' => $cartItem
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi.',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function countCartItems()
    {
        $count = 0;

        $count = Cart::where('user_id', Auth::id())->count();

        return response()->json(['count' => $count]);
    }

    public function saveSelectedItems(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (!$selectedItems) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa chọn sản phẩm nào!',
            ]);
        }

        session(['selected_items' => $selectedItems]);

        $cartItems = Cart::with('variant.product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedItems)
            ->get();


        $validSelectedItems = $cartItems->pluck('id')->toArray();
        if (count($selectedItems) !== count($validSelectedItems)) {
            session(['selected_items' => $validSelectedItems]);
        }


        return response()->json([
            'status' => true,
            'message' =>  '',
        ]);
    }

    public function updateCart(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);

        if ($cartItem) {
            $variant = $cartItem->variant;
            $newQuantity = $request->quantity;

            if ($newQuantity <= 0 || $newQuantity > $variant->quantity) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số lượng sản phẩm không hợp lệ',
                ]);
            }

            // Kiểm tra xem variant có trong chương trình flash sale đang diễn ra hay không
            $flashSaleProduct = $variant->product->flashSaleProducts()->where('variant_id', $variant->id)
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
                $flashSaleQty = min($newQuantity, $flashSaleProduct->quantity);
                $normalQty = $newQuantity - $flashSaleQty;

                $flashSalePrice = $flashSaleProduct->flash_price;
                $normalPrice = $variant->sale_price ?? $variant->listed_price;

                $totalPrice = ($flashSalePrice * $flashSaleQty) + ($normalPrice * $normalQty);

                $cartItem->quantity = $newQuantity;
                $cartItem->save();

                $message = $flashSaleQty < $newQuantity
                    ? "Số lượng sản phẩm đã vượt quá số lượng trong flash sale ($flashSaleProduct->quantity sản phẩm). Số lượng vượt sẽ được tính giá bình thường."
                    : 'Cập nhật số lượng thành công';

                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'data' => [
                        'total_price' => number_format($totalPrice),
                        'flash_sale_exceeded' => $flashSaleQty < $newQuantity
                    ],
                ]);
            } else {
                $price = $variant->sale_price ?? $variant->listed_price;
                $totalPrice = $price * $newQuantity;

                $cartItem->quantity = $newQuantity;
                $cartItem->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Cập nhật số lượng thành công',
                    'data' => [
                        'total_price' => number_format($totalPrice),
                        'flash_sale_exceeded' => false
                    ],
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy sản phẩm',
        ]);
    }
    public function deleteCartItem(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);

        if ($cartItem) {
            $cartItem->delete();

            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Cart item not found',
        ]);
    }

    public function calculateTotal(Request $request)
    {
        $items = $request->input('items');
        $subtotal = 0;
        $discount = 0;

        foreach ($items as $item) {
            $cart = Cart::with('variant')->find($item['id']);
            if ($cart) {
                $variant = $cart->variant;
                $product = $variant->product;

                // Kiểm tra xem variant có trong chương trình flash sale đang diễn ra hay không
                $flashSaleProduct = $product->flashSaleProducts()->where('variant_id', $variant->id)
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

                $quantity = $cart->quantity;
                $listedPrice = $variant->listed_price;
                $salePrice = $variant->sale_price ?? $listedPrice;

                if ($flashSaleProduct) {
                    $flashSaleQty = min($quantity, $flashSaleProduct->quantity);
                    $normalQty = $quantity - $flashSaleQty;

                    $flashSalePrice = $flashSaleProduct->flash_price;

                    $subtotal += $listedPrice * $quantity;

                    $discount += ($listedPrice - $flashSalePrice) * $flashSaleQty;
                    $discount += ($listedPrice - $salePrice) * $normalQty;
                } else {

                    $subtotal += $listedPrice * $quantity;
                    $discount += ($listedPrice - $salePrice) * $quantity;
                }
            }
        }

        $total = $subtotal - $discount;

        return response()->json([
            'subtotal' => $subtotal,
            'discount' => -$discount,
            'total' => $total,
        ]);
    }
}
