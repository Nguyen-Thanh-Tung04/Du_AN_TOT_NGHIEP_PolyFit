<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    use HasFactory;

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
}