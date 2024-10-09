<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'previous_status',
        'new_status',
        'cancel_reason',
        'changed_by',
        'changed_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
    public function newStatusName()
    {
        return Order::STATUS_NAMES[$this->new_status] ?? 'Trạng thái không xác định';
    }
}
