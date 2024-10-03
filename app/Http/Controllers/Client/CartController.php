<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast;

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
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|integer|exists:colors,id',
            'size_id' => 'nullable|integer|exists:sizes,id',
        ]);

        // Nếu không có cả size_id và color_id, tìm variant mặc định hợp lệ
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

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('variant_id', $variant->id)
            ->first();

        if ($cartItem) {
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
                    'message' => 'Số lượng không hợp lệ',
                ]);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật số lượng thành công',
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
}
