<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $lastname;
    public $email;
    public $phonenumber;
    public $address;

    public function __construct($firstname, $lastname, $email, $phonenumber, $address)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->address = $address;
    }

    public function build()
    {
        return $this->view('emails.lienhe')
            ->subject('Thông tin liên hệ từ người dùng')
            ->with([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phonenumber' => $this->phonenumber,
            'address' => $this->address,
         ]);
    }

    

}
