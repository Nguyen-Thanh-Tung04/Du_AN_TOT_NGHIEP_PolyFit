<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $status;
    protected $keyword;
    protected $startDate;
    protected $endDate;

    public function __construct($status = null, $keyword = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->keyword = $keyword;
        $this->startDate = $startDate ? Carbon::parse($startDate) : null;
        $this->endDate = $endDate ? Carbon::parse($endDate) : null;
    }

    /**
     * Get the collection of orders to export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Order::with(['user', 'voucher', 'province', 'district', 'ward']);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->keyword) {
            $query->where(function ($q) {
                $q->where('full_name', 'LIKE', '%' . $this->keyword . '%')
                  ->orWhere('code', 'LIKE', '%' . $this->keyword . '%')
                  ->orWhere('phone', 'LIKE', '%' . $this->keyword . '%');
            });
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->get();
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Mã đơn hàng', 'Tên khách hàng', 'Địa chỉ', 'Số điện thoại', 'Trạng thái', 'Phương thức thanh toán', 'Tổng giá trị', 'Mã voucher', 'Tên voucher', 'Ngày tạo'
        ];
    }

    /**
     * Map each order to the columns in the Excel file.
     *
     * @param  \App\Models\Order  $order
     * @return array
     */
    public function map($order): array
    {
        return [
            $order->code, 
            $order->full_name, 
            $this->getFullAddress($order), 
            $order->phone, 
            $order->statusName, 
            $order->paymentMethodName, 
            $order->total_price, 
            $order->voucher_code, 
            $this->getVoucherName($order), 
            $order->created_at->format('Y-m-d H:i:s'), 
        ];
    }

    /**
     * Get the full address including province, district, and ward.
     *
     * @param  \App\Models\Order  $order
     * @return string
     */
    protected function getFullAddress($order)
    {
        // Kiểm tra và trả về địa chỉ đầy đủ
        return $order->address . ', ' . 
               ($order->ward ? $order->ward->name : '') . ', ' . 
               ($order->district ? $order->district->name : '') . ', ' . 
               ($order->province ? $order->province->name : '');
    }

    /**
     * Get the voucher name or a default message if no voucher.
     *
     * @param  \App\Models\Order  $order
     * @return string
     */
    protected function getVoucherName($order)
    {
        // Kiểm tra nếu có voucher và lấy tên voucher
        return $order->voucher ? $order->voucher->name : 'Không có voucher';
    }
}
