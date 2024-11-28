<?php

namespace App\Jobs;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoCompleteOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    // Constructor để nhận ID đơn hàng
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    // Xử lý thay đổi trạng thái
    public function handle()
    {
        $order = Order::find($this->orderId);
        if ($order && $order->status == Order::STATUS_DA_GIAO_HANG) {
            $order->status = Order::STATUS_HOAN_THANH;  
            $order->save();
        }
    }
}
