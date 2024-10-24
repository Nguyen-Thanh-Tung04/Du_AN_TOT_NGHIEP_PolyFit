<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name', 'value', 'max_discount_value',
        'min_order_value', 'max_order_value', 'discount_type', 'quantity',
        'start_time', 'end_time', 'status'
    ];


    protected $table = 'vouchers';

    public function orders()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'id');
    }
}
