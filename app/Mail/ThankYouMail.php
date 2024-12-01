<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;

    public function __construct($firstname)
    {
        $this->firstname = $firstname;
    }

    public function build()
    {
        return $this->view('emails.thankyou')
                    ->subject('Cảm ơn bạn đã góp ý!')
                    ->with(['firstname' => $this->firstname]);
    }
}
