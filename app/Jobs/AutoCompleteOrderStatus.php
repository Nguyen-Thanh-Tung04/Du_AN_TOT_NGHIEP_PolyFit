<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);

        if (!$order) {
            Log::error("Order with ID {$this->orderId} not found.");
            return; 
        }

        if ($order->status == Order::STATUS_GIAO_HANG_THANH_CONG) {
            $previousStatus = $order->status;
            $order->status = Order::STATUS_HOAN_THANH;

            $changedBy = 'Hệ thống'; 

            if (auth()->check()) {
                $changedBy = auth()->user()->name; 
            }
            if ($order->save()) {
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'previous_status' => $previousStatus,
                    'new_status' => Order::STATUS_HOAN_THANH,
                    'cancel_reason' => null,  
                    'changed_by' => $changedBy,  
                    'changed_at' => now(),  
                ]);
            } else {
                Log::error("Failed to update order status for Order ID: " . $order->id);
            }
        } else {
            Log::info("Order ID {$this->orderId} is not eligible for status update.");
        }
    }
}
