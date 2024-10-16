<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ReviewInterface;
use App\Models\Review;


class ReviewRepository implements ReviewInterface
{
    public function getAll()
    {
        // Implement logic to get all categories
        return Review::all();
    }

    public function find($id)
    {
        return Review::query()
            ->join('users', 'reviews.account_id', '=', 'users.id')  // Kết nối với bảng users
            ->join('products', 'reviews.product_id', '=', 'products.id') // Kết nối với bảng products
            ->select(
                'reviews.*',
                'users.email',
                'users.name',       // Lấy tên người dùng
                'products.code as product_code' // Lấy mã sản phẩm
            )
            ->where('reviews.id', $id) // Tìm theo id của review
            ->first(); // Lấy ra bản ghi đầu tiên khớp với điều kiện  
    }

    public function pagination(
        array $columns = ['*'],
        array $conditions = [],
        int $perPage = 10,
        array $extend = []
    ) {
        $query = Review::query()
            ->join('users', 'reviews.account_id', '=', 'users.id')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('orders', 'reviews.order_id', '=', 'orders.id') // Join with the orders table
            ->select(
                'reviews.*',
                'users.email',
                'users.name',
                'users.image',
                'products.code as product_code',
                'orders.id as order_id' // Select order ID

            )
            ->orderBy('reviews.created_at', 'desc');

        // Thêm điều kiện tìm kiếm vào query
        if (!empty($conditions['keyword'])) {
            $query->where(function ($q) use ($conditions) {
                $q->where('orders.id', 'like', '%' . $conditions['keyword'] . '%')
                    ->orWhere('users.email', 'like', '%' . $conditions['keyword'] . '%');
            });
        }

        // Thêm điều kiện lọc theo trạng thái
        if (isset($conditions['status'])) {
            $query->where('reviews.status', $conditions['status']);
        }

        // Lọc theo trạng thái đã trả lời hay chưa
        if (isset($conditions['repluy'])) {
            if ($conditions['repluy'] == 1) {
                $query->whereHas('replies'); // Đánh giá đã trả lời
            } elseif ($conditions['repluy'] == 2) {
                $query->doesntHave('replies'); // Đánh giá chưa trả lời
            }
        }

        // Thực hiện paginate và trả về kết quả
        return $query->paginate($perPage, $columns);
    }



    public function delete(int $id = 0)
    {
        $review = Review::find($id);
    
        if (!$review) {
            return false;  // Chỉ trả về false nếu không tìm thấy review
        }
    
        return $review->delete();  // Trả về true nếu xóa thành công, false nếu xóa thất bại
    }
    

    // Cập nhật trạng thái
    public function update(int $id = 0, array $payload = [])
    {
        $reviewService = Review::findOrFail($id);
        $reviewService->update($payload);
        return $reviewService;
    }

    public function updateByWhereIn(
        string $whereInField = '',
        array $whereIn = [],
        array $payload = [],
    ) {
        return Review::whereIn($whereInField, $whereIn)->update($payload);
    }
    // Implement other methods as needed
}