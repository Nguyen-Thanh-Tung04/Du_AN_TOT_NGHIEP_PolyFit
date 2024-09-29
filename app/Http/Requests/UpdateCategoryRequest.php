<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'code' => 'required|string|unique:categories,code,' . $this->id . '|max:255',
            'name' => 'required|string|unique:categories,name,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Trường mã là bắt buộc.',
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Trường tên phải là chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'code.unique' => 'Mã này đã tồn tại.',
            'name.unique' => 'Tên này đã tồn tại.',
        ];
    }
}
