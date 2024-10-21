<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $resetLink;

    public function __construct($email, $resetLink)
    {
        $this->email = $email;
        $this->resetLink = $resetLink;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lấy lại mật khẩu tài khoản',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'client.passwords.reset_email', // Đường dẫn đến view email
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
