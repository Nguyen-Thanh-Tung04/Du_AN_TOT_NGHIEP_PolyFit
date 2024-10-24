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
            'code' => 'required|string|max:255|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0|max:100|required_if:discount_type,percentage',
    
            'max_discount_value' => 'nullable|numeric|min:0|required_if:discount_type,percentage',    
            'min_order_value' => 'required|numeric|min:0',
            'max_order_value' => 'required|numeric|min:0|gt:min_order_value',
    
            'discount_type' => 'required|in:percentage,fixed',
    
            'quantity' => 'required|integer|min:1',
    
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
    
            'status' => 'required|boolean',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $maxDiscountValue = $this->input('max_discount_value');
            $minOrderValue = $this->input('min_order_value');
            $maxOrderValue = $this->input('max_order_value');

            // Kiểm tra max_discount_value phải nhỏ hơn min_order_value
            if ($maxDiscountValue !== null && $minOrderValue !== null && $maxDiscountValue >= $minOrderValue) {
                $validator->errors()->add('max_discount_value', 'Giá trị giảm giá tối đa phải nhỏ hơn giá trị đơn hàng tối thiểu.');
            }

            // Kiểm tra max_discount_value phải nhỏ hơn max_order_value
            if ($maxDiscountValue !== null && $maxOrderValue !== null && $maxDiscountValue >= $maxOrderValue) {
                $validator->errors()->add('max_discount_value', 'Giá trị giảm giá tối đa phải nhỏ hơn giá trị đơn hàng tối đa.');
            }
        });
    }
    

    public function messages()
{
    return [
        'code.required' => 'Mã voucher là bắt buộc.',
        'code.string' => 'Mã voucher phải là một chuỗi.',
        'code.max' => 'Mã voucher không được vượt quá 255 ký tự.',
        'code.unique' => 'Mã voucher đã tồn tại.',

        'name.required' => 'Tên voucher là bắt buộc.',
        'name.string' => 'Tên voucher phải là một chuỗi.',
        'name.max' => 'Tên voucher không được vượt quá 255 ký tự.',

        'value.required' => 'Giá trị giảm giá là bắt buộc.',
        'value.numeric' => 'Giá trị giảm giá phải là một số.',
        'value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
        'value.max' => 'Giá trị giảm giá không được vượt quá 100%.', 

        'max_discount_value.required_if' => 'Giá trị giảm giá tối đa là bắt buộc khi loại giảm giá là "phần trăm".',
        'max_discount_value.numeric' => 'Giá trị giảm giá tối đa phải là một số.',
        'max_discount_value.min' => 'Giá trị giảm giá tối đa không được nhỏ hơn 0.',

        'min_order_value.required' => 'Giá trị đơn hàng tối thiểu là bắt buộc.',
        'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
        'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn 0.',

        'max_order_value.required' => 'Giá trị đơn hàng tối đa là bắt buộc.',
        'max_order_value.numeric' => 'Giá trị đơn hàng tối đa phải là một số.',
        'max_order_value.min' => 'Giá trị đơn hàng tối đa không được nhỏ hơn 0.',
        'max_order_value.gt' => 'Giá trị đơn hàng tối đa phải lớn hơn giá trị đơn hàng tối thiểu.',

        'discount_type.required' => 'Loại giảm giá là bắt buộc.',
        'discount_type.in' => 'Loại giảm giá không hợp lệ. Chỉ có thể là "phần trăm" hoặc "cố định".',

        'quantity.required' => 'Số lượng voucher là bắt buộc.',
        'quantity.integer' => 'Số lượng voucher phải là một số nguyên.',
        'quantity.min' => 'Số lượng voucher không được nhỏ hơn 1.',

        'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
        'start_time.date' => 'Thời gian bắt đầu phải là một ngày hợp lệ.',
        'start_time.after_or_equal' => 'Thời gian bắt đầu phải là hôm nay hoặc sau.',

        'end_time.required' => 'Thời gian kết thúc là bắt buộc.',
        'end_time.date' => 'Thời gian kết thúc phải là một ngày hợp lệ.',
        'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',

        'status.required' => 'Trạng thái là bắt buộc.',
        'status.boolean' => 'Trạng thái phải là đúng hoặc sai.',
    ];
}

}
