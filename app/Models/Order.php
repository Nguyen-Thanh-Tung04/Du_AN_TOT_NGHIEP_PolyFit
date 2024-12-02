<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_CHO_XAC_NHAN = 1;
    const STATUS_DA_XAC_NHAN = 2;
    const STATUS_DANG_CHUAN_BI = 3;
    const STATUS_DANG_VAN_CHUYEN = 4;
    const STATUS_GIAO_HANG_THANH_CONG = 5;
    const STATUS_HOAN_THANH = 6;
    const STATUS_HUY_DON_HANG = 7;

    const STATUS_NAMES = [
        self::STATUS_CHO_XAC_NHAN => 'Chờ xác nhận',
        self::STATUS_DA_XAC_NHAN => 'Đã xác nhận',
        self::STATUS_DANG_CHUAN_BI => 'Đang chuẩn bị',
        self::STATUS_DANG_VAN_CHUYEN => 'Đang vận chuyển',
        self::STATUS_GIAO_HANG_THANH_CONG => 'Giao hàng thành công',
        self::STATUS_HUY_DON_HANG => 'Hủy đơn hàng',
        self::STATUS_HOAN_THANH => 'Hoàn thành',
    ];
    const PAYMENT_METHOD_COD = 1;
    const PAYMENT_METHOD_ONLINE = 2;

    const PAYMENT_METHOD_NAMES = [
        self::PAYMENT_METHOD_COD => 'Thanh toán khi nhận hàng',
        self::PAYMENT_METHOD_ONLINE => 'Thanh toán VNPAY',
        self::PAYMENT_METHOD_ONLINE => 'Thanh toán MOMO',

    ];

    protected $fillable = [
        'user_id',
        'code',
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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function voucher()
    {
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

    // Lấy tất cả các đánh giá liên quan đến các sản phẩm trong đơn hàng
    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,  // Model Review
            OrderItem::class,  // Model trung gian OrderItem
            'order_id',  // Khóa ngoại trong OrderItem
            'product_id',  // Khóa ngoại trong Review
            'id',  // Khóa chính của Order
            'variant_id'  // Khóa chính của sản phẩm trong Review
        );
    }

    public function getHasReviewAttribute()
    {
        // Kiểm tra nếu tất cả các sản phẩm trong đơn hàng đã có đánh giá trong đúng đơn hàng đó
        return $this->orderItems->every(function ($item) {
            return Review::where('product_id', $item->variant->product_id)
                ->where('order_id', $this->id) // Kiểm tra xem đánh giá là của đúng đơn hàng này
                ->exists();
        });
    }
}
