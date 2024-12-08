<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Variant;

use function PHPUnit\Framework\isEmpty;

class CheckVariantChildrenRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    
    protected $variantId;

    public function __construct($variantId)
    {
        $this->variantId = $variantId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $variantId = $arrVariantIds = explode(',', rtrim($this->variantId, ','));
        $variant = Variant::with('order_items.order')->find($variantId);

        if (!$variant) {
            $fail('Biến thể không tồn tại.');
            return;
        }
        // Kiểm tra các order_items liên quan đến variant
        foreach ($variant as $var) {
            // Lấy trạng thái của đơn hàng từ mối quan hệ 'order'
            if (!$var->order_items->isEmpty()) {
                foreach ($var->order_items as $item) {
                    $orderStatus = $item->order->status;
                    // Kiểm tra nếu trạng thái đơn hàng không phải là 5 hoặc 6, 7
                    if ($orderStatus == 1 || $orderStatus == 2 || $orderStatus == 3 || $orderStatus == 4) {
                        $fail('Không thể xóa biến thể do đang còn đơn hàng chưa hoàn thành.');
                        return;
                    }
                }
            }
        }
    }

    public function message()
    {
        return 'Không thể xóa biến thể do đang còn đơn hàng chưa hoàn thành1.';
    }
}