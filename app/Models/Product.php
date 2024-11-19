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

    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }

    // Phương thức tính trung bình đánh giá
    public function averageScore()
    {
        // Lấy điểm trung bình của các đánh giá có status = 1 và chưa bị xóa mềm
        $avgScore = $this->reviews()
            ->where('status', 1) // Chỉ tính các đánh giá hợp lệ
            ->whereNull('deleted_at') // Loại bỏ các đánh giá đã bị xóa mềm
            ->avg('score'); // Tính trung bình điểm số

        return $avgScore ? round($avgScore) : null; // Làm tròn đến số nguyên
    }

    // Quan hệ với Review
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}
