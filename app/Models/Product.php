<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'gallery',
        'description',
        'status',
        'category_id',
    ];

    protected $table = 'products';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }
    // Phương thức tính trung bình đánh giá
    public function averageScore()
    {
        // Sử dụng quan hệ reviews để tính điểm trung bình
        // return $this->reviews()
        //     ->where('status', 1)  // Nếu có status để xác nhận đánh giá hợp lệ
        //     ->avg('score');  // Tính trung bình điểm số

            $avgScore = $this->reviews()
            ->where('status', 1) // Chỉ tính các đánh giá hợp lệ
            ->avg('score');
    
        return $avgScore ? round($avgScore) : null;  // Làm tròn đến số nguyên
    }

    // Quan hệ với Review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}