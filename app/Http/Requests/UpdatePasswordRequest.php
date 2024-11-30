<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password'=>['required', 'min:8'],
            'new_password' => ['required', 'string', 'min:8','confirmed'],
            'new_password_confirmation'=>['required','string','min:8'],
        ];
    }
    public function messages(): array
    {
        return [
            'current_password.required'=>'Không được để trống mật khẩu',
            'new_password.required'=>'Không được để trống mật khẩu',
            'new_password.string'=>'Mật khẩu phải là một chuỗi ký tự',
            'new_password.min'=>'Mật khẩu tối thiểu 8 ký tự',
            'new_password.confirmed'=>'Mật khẩu phải trùng khớp',
            'new_password_confirmation.required'=>'Mật khẩu không được để trống',
            'new_password_confirmation.string'=>'Mật khẩu phải là một chuỗi ký tự',
            'new_password_confirmation.min'=>'Mật khẩu tối thiểu 8 ký tự',
        ];
    }

    protected function prepareForValidation()
    {
        // Lưu các giá trị vào session
        session()->flash('new_password', $this->new_password);
    }
}
