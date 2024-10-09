<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
        'product_id' => 'required|exists:products,id',
        'review_text' => 'required|string',
        'rate' => 'required|integer|min:1|max:5',
        'review_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Adjust validation rules as necessary
        ], [
        'product_id.required' => 'ID sản phẩm là bắt buộc.',
        'product_id.exists' => 'ID sản phẩm không hợp lệ.',
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

        // Create a new review
        $review = Review::create([
            'product_id' => $request->input('product_id'),
            'account_id' => auth()->id(),
            'content' => $request->input('review_text'),
            'image' => $imagePath,
            'score' => $request->input('rate'),
            'status' => 1,
        ]);

        // Prepare response data
        return response()->json([
            'success' => true,
            'message' => 'Đánh giá của bạn đã được lưu',
            'name' => $review->user->name, // Assuming you have a relationship with User
            'content' => $review->content,
            'score' => $review->score,
            'image' => $imagePath ? asset('storage/' . $imagePath) : null,
        ]);
    }
    
}