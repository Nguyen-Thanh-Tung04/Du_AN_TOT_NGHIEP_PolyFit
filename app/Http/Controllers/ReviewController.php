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
        // Bỏ qua bước validate

        // Lưu ảnh nếu có
        if ($request->hasFile('review_image')) {
            $imagePath = $request->file('review_image')->store('review_images', 'public');
        } else {
            $imagePath = '';
        }

        // Tạo một review mới mà không cần xác thực
        Review::create([
           'product_id' => $request->input('product_id'), // ID sản phẩm từ form
            'account_id' => auth()->id(),  // ID người dùng hiện tại
            'content' => $request->input('review_text'), // Nội dung đánh giá
            'image' => $imagePath, // Đường dẫn hình ảnh
            'score' => $request->input('rate'), // Điểm đánh giá
            'status' => 1 // Ví dụ: bạn có thể thiết lập trạng thái mặc định là 
        ]);

        return response()->json(['success' => true, 'message' => 'Đánh giá của bạn đã được lưu']);
    }
    
}