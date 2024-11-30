<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'title_main' => 'required|string|max:255',
            'title_sub' => 'required|string|max:255',
            'content'=>'required|string|max:255',
            'image' => 'required',
            'link'=> 'required|url',
            'is_active' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'title_main.required' => 'Trường tiêu đề chính  là bắt buộc.',
            'title_main.string' => 'Trường tiêu đề chính phải là chuỗi ký tự.',
            'title_main.max' => 'Trường tiêu đề chính không được quá 255 ký tự ',
            'title_sub.required' => 'Trường tiêu đề phụ  là bắt buộc.',
            'title_sub.string' => 'Trường tiêu đề phụ phải là chuỗi ký tự.',
            'title_sub.max:255' => 'Trường tiêu đề phụ không được quá 255 ký tự ',
            'content.required' => 'Trường tiêu đề chính  là bắt buộc.',
            'content.string' => 'Trường tiêu đề chính phải là chuỗi ký tự.',
            'content.max:255' => 'Trường tiêu đề chính không được quá 255 ký tự ',
            'image.required' => 'Không được để trống ảnh',
            'link.required' =>'Không được để trống đường dẫn',
            'link.url'=> 'Phải là một đường dẫn',
        ];
    }
}
