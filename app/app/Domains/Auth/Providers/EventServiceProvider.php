<?php

namespace App\Domains\Auth\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domains\Auth\Events\{
    EmailVerificationRequested,
    ForgotPassword,
    TwoFactorRegistered
};
use App\Domains\Auth\Listeners\{
    SendEmailVerificationListener,
    SendForgotPassword,
    SendTwoFactorCode
};

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EmailVerificationRequested::class => [
            SendEmailVerificationListener::class,
        ],
        ForgotPassword::class => [
            SendForgotPassword::class,
        ],
        TwoFactorRegistered::class => [
            SendTwoFactorCode::class,
        ],
    ];
}
