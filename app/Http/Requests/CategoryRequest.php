<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category_id = $this->route('category') ? $this->route('category')->id : null;

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category_id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^\d]+$/',
                Rule::unique('categories')->ignore($category_id),
            ],
            'image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ],
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
            'name.regex' => 'Trường tên không được chứa số.',
            'image.mimes' => 'Tệp được tải lên phải là một hình ảnh (jpeg, png, jpg, gif).',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
        ];
    }
}