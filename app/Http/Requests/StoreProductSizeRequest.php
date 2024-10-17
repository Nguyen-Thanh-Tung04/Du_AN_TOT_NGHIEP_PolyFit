<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductSizeRequest extends FormRequest
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
            'name.*' => 'required|string|max:255|unique:sizes,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.*.required' => 'Bạn chưa nhập tên kích cỡ.',
            'name.*.string' => 'Tên kích cỡ phải là dạng kí tự.',
            'name.*.max' => 'Tên kích cỡ tối đa 255 kí tự.',
            'name.*.unique' => 'Tên kích cỡ đã tồn tại.',
        ];
    }
}
