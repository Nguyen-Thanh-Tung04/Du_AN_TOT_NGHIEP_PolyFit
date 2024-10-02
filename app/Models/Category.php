<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'image',
        'is_active'
    ];

    protected $table = 'categories';
    
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}