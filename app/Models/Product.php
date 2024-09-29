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

    public function categories() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
