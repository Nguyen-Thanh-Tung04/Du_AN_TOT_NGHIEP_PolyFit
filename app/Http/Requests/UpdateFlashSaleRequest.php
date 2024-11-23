<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFlashSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
            'status.required' => 'Trạng thái là bắt buộc.',
            'products.required' => 'Danh sách sản phẩm là bắt buộc.',
            'products.*.*.variant_id.exists' => 'Mã biến thể không tồn tại.',
            'products.*.*.flash_price.required' => 'Giá khuyến mãi là bắt buộc.',
            'products.*.*.discount_percentage.max' => 'Phần trăm giảm giá không được vượt quá 100%.',
            // Thêm các thông báo lỗi khác theo nhu cầu
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
