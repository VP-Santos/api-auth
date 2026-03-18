<?php

namespace App\Domains\Auth\Mail;

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
        return $this->subject('Two-Factor Authentication')
                    ->view('email.twoFactor', ['twoFactor' => $this->twoFactor]);
    }
}
