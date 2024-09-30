<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variants extends Model
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
}
