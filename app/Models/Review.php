<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',      // Liên kết với đơn hàng
        'product_id',    // Liên kết với sản phẩm trong đơn hàng
        'account_id',    // Người dùng đánh giá
        'content',
        'image',
        'score',
        'status'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'account_id');
    }
    public function replies()
    {
        return $this->hasMany(ReviewReply::class, 'review_id');
    }
    // Quan hệ với đơn hàng (Order)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
