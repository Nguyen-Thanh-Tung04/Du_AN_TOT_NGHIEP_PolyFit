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

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function variants() {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }
}
