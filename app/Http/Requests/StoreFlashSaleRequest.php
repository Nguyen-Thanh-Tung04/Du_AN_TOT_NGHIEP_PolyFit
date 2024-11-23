<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlashSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:0-9,9-12,12-15,15-18,18-21,21-24',
            'status' => 'required|integer|in:0,1',
            'products' => 'required|array',
            'products.*.*.variant_id' => 'required|integer|exists:variants,id',
            'products.*.*.flash_price' => 'required|numeric|min:0',
            'products.*.*.listed_price' => 'required|numeric|min:0',
            'products.*.*.discount_percentage' => 'required|numeric|min:0|max:100',
            'products.*.*.quantity' => 'required|integer|min:0',
            'products.*.*.status' => 'required|integer|in:0,1',
        ];
    }



    public function messages()
    {
        return [
            'date.required' => 'Ngày là bắt buộc.',
            'date.date' => 'Ngày không hợp lệ.',
            'date.after_or_equal' => 'Ngày phải bằng hoặc sau ngày hôm nay.',
            'time_slot.required' => 'Khung giờ là bắt buộc.',
            'time_slot.in' => 'Khung giờ không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.integer' => 'Trạng thái phải là một số nguyên.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'products.required' => 'Danh sách sản phẩm là bắt buộc.',
            'products.array' => 'Danh sách sản phẩm phải là một mảng.',
            'products.*.*.variant_id.required' => 'Mã biến thể là bắt buộc.',
            'products.*.*.variant_id.integer' => 'Mã biến thể phải là một số nguyên.',
            'products.*.*.variant_id.exists' => 'Biến thể không tồn tại.',
            'products.*.*.flash_price.required' => 'Giá flash sale là bắt buộc.',
            'products.*.*.flash_price.numeric' => 'Giá flash sale phải là một số.',
            'products.*.*.flash_price.min' => 'Giá flash sale phải lớn hơn hoặc bằng 0.',
            'products.*.*.listed_price.required' => 'Giá niêm yết là bắt buộc.',
            'products.*.*.listed_price.numeric' => 'Giá niêm yết phải là một số.',
            'products.*.*.listed_price.min' => 'Giá niêm yết phải lớn hơn hoặc bằng 0.',
            'products.*.*.discount_percentage.required' => 'Phần trăm giảm giá là bắt buộc.',
            'products.*.*.discount_percentage.numeric' => 'Phần trăm giảm giá phải là một số.',
            'products.*.*.discount_percentage.min' => 'Phần trăm giảm giá phải lớn hơn hoặc bằng 0.',
            'products.*.*.discount_percentage.max' => 'Phần trăm giảm giá không được vượt quá 100.',
            'products.*.*.quantity.required' => 'Số lượng là bắt buộc.',
            'products.*.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'products.*.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'products.*.*.status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'products.*.*.status.integer' => 'Trạng thái sản phẩm phải là một số nguyên.',
            'products.*.*.status.in' => 'Trạng thái sản phẩm không hợp lệ.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors()->first()
        ]));
    }
}
