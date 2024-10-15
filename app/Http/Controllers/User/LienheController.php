<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LienheController extends Controller
{
    public function Create() {
        return view('client.page.contact');
    }

    public function sendMail(Request $request) {
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $email = $request['email'];
        $phonenumber = $request['phonenumber'];
        $address = $request['address'];

        // gửi mail
        Mail::mailer()
        ->to('hunglqph43302@fpt.edu.vn')
        ->send(new SendMail($firstname, $lastname, $email, $phonenumber, $address));
        return "Gửi liên hệ thành công.";
    }
}
