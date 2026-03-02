<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorVerify extends Mailable
{
    use Queueable, SerializesModels;

    public $twoFactor;

    public function __construct($twoFactor)
    {
        $this->twoFactor = $twoFactor;
    }

    public function build()
    {
        return $this->subject('Verifique seu e-mail')
                    ->view('email.twoFactor', ['twoFactor' => $this->twoFactor]);
    }
}
