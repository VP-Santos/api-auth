<?php

namespace App\Domains\Auth\Listeners;

use App\Domains\Auth\Events\EmailVerificationRequested;
use App\Domains\Auth\Mail\VerifyEmailMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    
    public $queue = 'email-verification';

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmailVerificationRequested $event): void
    {
        Mail::to($event->user->email)
            ->send(new VerifyEmailMail($event->token));
    }
}
