<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_slot',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }
}
