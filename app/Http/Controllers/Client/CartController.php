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

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            $totalPrice = ($variant->sale_price ?? $variant->listed_price) * $cartItem->quantity;

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật số lượng thành công',
                'data' => [
                    'total_price' => number_format($totalPrice)
                ],
            ]);
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
                $salePrice = $cart->variant->sale_price;
                $listedPrice = $cart->variant->listed_price;
                $quantity = $cart->quantity;

                $subtotal += $listedPrice * $quantity;
                $discount += ($listedPrice - $salePrice) * $quantity;
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
