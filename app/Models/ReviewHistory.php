<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Thêm trait SoftDeletes


class ReviewHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'review_id',
        'reply_id',   // Lưu lịch sử của phản hồi đánh giá
        'user_id',
        'content',
        'score',      // Dành cho review
        'action',
        'type',       // "review" hoặc "reply"
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function reply()
    {
        return $this->belongsTo(ReviewReply::class, 'reply_id');  // Liên kết với reply
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  // Người thực hiện hành động
    }
}
