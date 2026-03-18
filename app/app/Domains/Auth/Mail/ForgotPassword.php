<?php

namespace App\Domains\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $forgotToken;

    public function __construct($forgotToken)
    {
        $this->forgotToken = $forgotToken;
    }

    public function build()
    {
        $link = url(config('domains.reset') . '?token=' . $this->forgotToken);
        return $this->subject('PASSWORD RESET VERIFICATION')
                    ->view('email.forgotPassword', ['link' => $link]);
    }
}
