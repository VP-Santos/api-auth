<?php

namespace App\Listeners;

use App\Events\TwoFactorRegistered;
use App\Mail\TwoFactorVerify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTwoFactorCode
{
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
    public function handle(TwoFactorRegistered $event): void
    {
        Mail::to($event->user->email)
            ->send(new TwoFactorVerify($event->code));
    }
}
