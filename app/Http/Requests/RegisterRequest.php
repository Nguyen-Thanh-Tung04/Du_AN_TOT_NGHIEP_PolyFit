<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Kiểm tra email đã tồn tại
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function messages()
    {
        return [
                'name.required' => 'Vui lòng nhập tên.',
                'name.string' => 'Tên phải là chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 255 ký tự.',

                'email.required' => 'Vui lòng nhập email.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.email' => 'Email phải đúng định dạng.',
                'email.max' => 'Email không được vượt quá 255 ký tự.',
                'email.unique' => 'Email này đã tồn tại trong hệ thống.', // Thông báo nếu email đã tồn tại

                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ];
    }
}
