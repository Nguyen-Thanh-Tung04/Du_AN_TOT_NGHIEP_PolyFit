<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order; // Import Order model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'id_order' => 'required|integer|exists:orders,id', // Validate id_order
                'review_text' => 'required|string',
                'rate' => 'required|integer|min:1|max:5',
                'review_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'id_order.required' => 'ID đơn hàng là bắt buộc.',
                'id_order.exists' => 'Đơn hàng không tồn tại.',
                'review_text.required' => 'Bạn phải nhập nội dung đánh giá.',
                'rate.required' => 'Bạn phải chọn số sao.',
                'review_image.image' => 'Tệp ảnh không hợp lệ.',
                'review_image.mimes' => 'Chỉ chấp nhận định dạng ảnh jpg, jpeg, png.',
                'review_image.max' => 'Ảnh không được quá 2MB.',
            ]);

            // Save the image if provided
            $imagePath = $request->hasFile('review_image')
                ? $request->file('review_image')->store('review_images', 'public')
                : '';

            // Retrieve the order and its items
            $order = Order::with('orderItems')->findOrFail($request->input('id_order'));
            $products = $order->orderItems->pluck('variant.product_id')->unique(); // Get unique product IDs

            // Create a new review for each product
            foreach ($products as $productId) {
                Review::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'account_id' => auth()->id(),
                    'content' => $request->input('review_text'),
                    'image' => $imagePath,
                    'score' => $request->input('rate'),
                    'status' => 1,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đánh giá của bạn đã được lưu.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu nhập vào không hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        }
    }
    public function getReviews($orderId)
    {
        $order = Order::with('orderItems.variant.product')->findOrFail($orderId);
        $reviews = Review::whereIn('product_id', $order->orderItems->pluck('variant.product_id'))
            ->with('user')
            ->get();

        return response()->json([
            'reviews' => $reviews,
        ]);
    }

}