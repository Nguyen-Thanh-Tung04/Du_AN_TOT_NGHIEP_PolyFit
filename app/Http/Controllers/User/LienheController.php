<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Mail\ThankYouMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LienheController extends Controller
{
    public function create()
    {
        return view('client.page.contact');
    }

    public function sendMail(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'firstname'   => 'required|string|max:50',
            'lastname'    => 'required|string|max:50',
            'email'       => 'required|email:rfc,dns|max:100',
            'phonenumber' => 'required|digits_between:10,15',
            'address'     => 'required|string|max:255',
        ], [
            // Custom error messages
            'firstname.required'   => 'Họ không được để trống.',
            'firstname.max'        => 'Họ không được vượt quá 50 ký tự.',
            'lastname.required'    => 'Tên không được để trống.',
            'lastname.max'         => 'Tên không được vượt quá 50 ký tự.',
            'email.required'       => 'Email không được để trống.',
            'email.email'          => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max'            => 'Email không được vượt quá 100 ký tự.',
            'phonenumber.required' => 'Số điện thoại không được để trống.',
            'phonenumber.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số.',
            'address.required'     => 'Nhận xét/Câu hỏi không được để trống.',
            'address.max'          => 'Nhận xét/Câu hỏi không được vượt quá 255 ký tự.',
        ]);

        // Send the contact email
        Mail::to('hunglqph43302@fpt.edu.vn')->send(new SendMail(
            $validatedData['firstname'],
            $validatedData['lastname'],
            $validatedData['email'],
            $validatedData['phonenumber'],
            $validatedData['address']
        ));

        // Send the thank you email
        Mail::to($validatedData['email'])->send(new ThankYouMail($validatedData['firstname']));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Gửi liên hệ thành công.');
    }
}
