<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'description',
        'status'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function variants(){
        return $this->belongsTo(Variants::class);
    }
}
