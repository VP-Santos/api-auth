<?php

namespace App\Domains\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        $url = config('domains.verifyEmail') . '?token=' . $this->token;
        return $this->subject('Verifique seu e-mail')
                    ->view('email.VerifyEmail')
                    ->with([
                        'linkToken' => $url
                    ]);
    }
}
