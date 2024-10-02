<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductColorRequest extends FormRequest
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
            'name.*' => 'required|max:255|unique:colors,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.*.required' => 'Bạn chưa nhập tên màu sắc.',
            'name.*.max' => 'Tên màu sắc tối đa 255 kí tự.',
            'name.*.unique' => 'Tên màu sắc đã tồn tại.',
        ];
    }
}
