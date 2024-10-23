<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $product_name;
    public $image;

    public function __construct(Order $order)
    {
        $this->order = $order;
        // Ghi log để kiểm tra

        Log::info('Sự kiện OrderPlaced đã được phát cho đơn hàng: ' . $order->id);


        // Lấy sản phẩm đầu tiên trong đơn hàng
        // $firstItem = $order->orderItems()->first();
        // $this->product_name = $firstItem->product->name;
        // $this->image = $firstItem->product->image ?? 'default-image.jpg'; // Truyền ảnh mặc định nếu không có ảnh
        // Lấy sản phẩm đầu tiên trong đơn hàng (thông qua variant)
        $firstItem = $order->orderItems()->with('variant.product')->first();

        if ($firstItem && $firstItem->variant && $firstItem->variant->product) {
            $this->product_name = $firstItem->variant->product->name;
            $gallery = json_decode($firstItem->variant->product->gallery);
            $this->image = !empty($gallery) ? $gallery[0] : "";
        } else {
            $this->product_name = 'Sản phẩm không xác định';
            $this->image = 'default-image.jpg'; // Ảnh mặc định
        }
        Log::info('Sự kiện OrderPlaced đã được phát cho sản phẩm', [
            'order_item' => $firstItem,
            'product_name' => $this->product_name,
            'image' => $this->image
        ]);
    }

    public function broadcastOn()
    {
        return ['orders-channel']; // Kênh phát sự kiện
    }
}
