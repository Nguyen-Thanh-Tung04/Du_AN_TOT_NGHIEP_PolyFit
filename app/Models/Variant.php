<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'purchase_price',
        'listed_price',
        'sale_price',
        'quantity',
        'status',
    ];

    protected $table = 'variants';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

    public function flashsale()
    {
        return $this->hasMany(FlashSaleProduct::class, 'variant_id', 'id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'variant_id', 'id');
    }
}
