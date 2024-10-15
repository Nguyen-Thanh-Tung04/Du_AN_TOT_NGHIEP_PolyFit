<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Define constants for order statuses
    const STATUS_CHO_XAC_NHAN = 1; // Waiting for confirmation
    const STATUS_DA_XAC_NHAN = 2; // Confirmed
    const STATUS_DANG_CHUAN_BI = 3; // Preparing
    const STATUS_DANG_VAN_CHUYEN = 4; // In transit
    const STATUS_DA_GIAO_HANG = 5; // Delivered
    const STATUS_HUY_DON_HANG = 6; // Order cancelled

    // Mapping status constants to human-readable names
    const STATUS_NAMES = [
        self::STATUS_CHO_XAC_NHAN => 'Chờ xác nhận',
        self::STATUS_DA_XAC_NHAN => 'Đã xác nhận',
        self::STATUS_DANG_CHUAN_BI => 'Đang chuẩn bị',
        self::STATUS_DANG_VAN_CHUYEN => 'Đang vận chuyển',
        self::STATUS_DA_GIAO_HANG => 'Đã giao hàng',
        self::STATUS_HUY_DON_HANG => 'Đơn hàng đã hủy',
    ];
     // Define constants for payment methods
     const PAYMENT_METHOD_COD = 1; // Cash on delivery
     const PAYMENT_METHOD_ONLINE = 2; // Online payment
 
     // Mapping payment method constants to human-readable names
     const PAYMENT_METHOD_NAMES = [
         self::PAYMENT_METHOD_COD => 'Thanh toán khi nhận hàng',
         self::PAYMENT_METHOD_ONLINE => 'Thanh toán trực tuyến',
     ];

    protected $fillable = [
        'user_id',
        'voucher_id',
        'voucher_code',
        'full_name',
        'province_id',
        'district_id',
        'ward_id',
        'address',
        'phone',
        'note',
        'status',
        'shipping_cost',
        'total_price',
        'discount_amount',
        'payment_method',
    ];

    protected $table = 'orders';

    public function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function voucher(){
        return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'code');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'code');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'code');
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    // Method to get the display name for the order status
    public function getStatusNameAttribute()
    {
        return self::STATUS_NAMES[$this->status] ?? 'Trạng thái không xác định';
    }
    public function getPaymentMethodNameAttribute()
    {
        return self::PAYMENT_METHOD_NAMES[$this->payment_method] ?? 'Phương thức thanh toán không xác định';
    }
    
}
