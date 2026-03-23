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
        // $url = config('domains.verifyEmail') . '?token=' . $this->token;
        $url = config('domains.verifyEmail') . '?token=' . $this->token;
        return $this->subject('CONFIRM EMAIL')
            ->html('
                <html>
                    <body>
                        <p>Olá,</p>
                        <p>Por favor, confirme seu e-mail clicando no link abaixo:</p>
                        <p><a href="' . $url . '">Confirmar E-mail</a></p>
                        <p>Obrigado!</p>
                    </body>
                </html>
            ');
    }
}
