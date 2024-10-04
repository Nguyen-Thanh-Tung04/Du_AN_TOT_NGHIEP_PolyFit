<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
       'product_id',
        'account_id',
        'content',
        'image',
        'score',
        'status'
    ];
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'account_id');
    }
}