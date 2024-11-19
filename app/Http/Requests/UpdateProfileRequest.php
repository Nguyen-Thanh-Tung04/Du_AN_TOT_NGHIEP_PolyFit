<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|',
            'phone' => 'digits:10',
            'birthday' =>'date',
            'province_id' => 'max:255',
            'district_id' => 'max:255',
            'ward_id' => 'max:255',
            'address' => 'max:255',
        ];
    }
    public function messages(): array{
        return[
            'name.required'=> 'Không được để trống tên ',
            'email.required'=>'Không được để trống email',
            'email.email'=>'Email không đúng định dạng',
            'phone.digits:10'=>'Số điện thoại không đúng',
            'birthday.date'=>'Ngày sinh không đúng'
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors= $validator->errors();
        throw new ValidationException($validator,
        redirect()->back()->with('error', 'Cập nhật không thành công!')->withErrors($validator));
    }
}
