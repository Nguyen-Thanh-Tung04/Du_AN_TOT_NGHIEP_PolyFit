<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:vouchers',
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'max_discount_value' => 'required|numeric',
            'min_order_value' => 'required|numeric',
            'discount_type' => 'required|in:fixed,percentage',
            'quantity' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.unique' => 'Mã voucher phải là duy nhất.',
            'name.required' => 'Tên voucher là bắt buộc.',
            'value.required' => 'Giá trị voucher là bắt buộc.',
            'max_discount_value'=>'Giá trị tối đa là bắt buôc.',
            'min_order_value.required' => 'Giá trị đơn hàng tối thiểu là bắt buộc.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'quantity.required' => 'Số lượng voucher là bắt buộc.',
            'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
            'end_time.required' => 'Thời gian kết thúc là bắt buộc.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}
