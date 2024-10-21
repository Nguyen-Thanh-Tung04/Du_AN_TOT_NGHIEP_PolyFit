<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ReviewHistory;

class Review extends Model
{
    use HasFactory, SoftDeletes;
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
    public function history()
    {
        return $this->hasMany(ReviewHistory::class, 'review_id', 'id');
    }

    // Ghi lại lịch sử khi tạo mới, cập nhật hoặc xóa đánh giá
    protected static function booted()
    {
        static::created(function ($review) {
            ReviewHistory::create([
                'review_id' => $review->id,
                'user_id' => $review->account_id,
                'content' => $review->content,
                'score' => $review->score,
                'action' => 'create',
                'type' => 'review',
            ]);
        });

        static::updated(function ($review) {
            ReviewHistory::create([
                'review_id' => $review->id,
                'user_id' => $review->account_id,
                'content' => $review->content,
                'score' => $review->score,
                'action' => 'update',
                'type' => 'review',
            ]);
        });

        static::deleting(function ($review) {
            ReviewHistory::create([
                'review_id' => $review->id,
                'user_id' => $review->account_id,
                'content' => $review->content,
                'score' => $review->score,
                'action' => 'delete',
                'type' => 'review',
            ]);
        });
    }
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }
}
