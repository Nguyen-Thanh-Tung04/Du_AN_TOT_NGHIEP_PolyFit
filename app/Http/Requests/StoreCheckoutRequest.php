<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Tên đầy đủ là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'province_id.required' => 'Tỉnh thành là bắt buộc.',
            'district_id.required' => 'Quận huyện là bắt buộc.',
            'ward_id.required' => 'Phường xã là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
        ];
    }
}
