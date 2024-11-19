<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
     
        return Order::with(['user', 'voucher', 'province', 'district', 'ward'])->get();
    }

    public function headings(): array
    {
        return [
            'Mã đơn hàng', 'Tên khách hàng', 'Địa chỉ', 'Số điện thoại', 'Trạng thái', 'Phương thức thanh toán', 'Tổng giá trị', 'Mã voucher', 'Tên voucher', 'Ngày tạo'
        ];
    }

    public function map($order): array
    {
        return [
            $order->code,
            $order->full_name,
            $order->address . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name,
            $order->phone,
            $order->statusName,  
            $order->paymentMethodName,  
            $order->total_price,
            $order->voucher_code,
            $order->voucher ? $order->voucher->name : 'Không có voucher', // Kiểm tra nếu có voucher
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
