<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ReviewHistory;

class ReviewReply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'review_id',
        'user_id',
        'content',
    ];

    // Quan hệ tới bảng Review
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    // Quan hệ tới bảng User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Ghi lại lịch sử khi tạo mới, cập nhật hoặc xóa
    protected static function booted()
    {
        static::created(function ($reply) {
            ReviewHistory::create([
                'reply_id' => $reply->id,
                'user_id' => $reply->user_id,
                'content' => $reply->content,
                'action' => 'create',
                'type' => 'reply',
            ]);
        });

        static::updated(function ($reply) {
            ReviewHistory::create([
                'reply_id' => $reply->id,
                'user_id' => $reply->user_id,
                'content' => $reply->content,
                'action' => 'update',
                'type' => 'reply',
            ]);
        });

        static::deleted(function ($reply) {
            ReviewHistory::create([
                'reply_id' => $reply->id,
                'user_id' => $reply->user_id,
                'content' => $reply->content,
                'action' => 'delete',
                'type' => 'reply',
            ]);
        });
    }
}
