<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Mail\ForgotPassword as MailForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotPassword implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ForgotPassword $event): void
    {
        Mail::to($event->user->email)
            ->send(new MailForgotPassword($event->token));
    }
}
