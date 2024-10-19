<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'variant_id',
        'order_id',
        'image',
        'price',
        'color',
        'size',
        'quantity',
    ];

    protected $table = 'order_items';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }

    public function product()
    {
        return $this->variant->product(); // Nếu Variant có quan hệ với Product
    }
    // Lấy tất cả đánh giá của sản phẩm thuộc OrderItem
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'variant_id');
    }
}
