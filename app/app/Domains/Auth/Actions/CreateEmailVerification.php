<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Str;

class CreateEmailVerification
{
    public function execute(User $user): string
    {
        $plainToken = hash('sha256',Str::random(64));

        EmailVerification::create([
            'user_id' => $user->id,
            'token' =>  $plainToken,
            'expires_at' => now()->addMinutes(30),
        ]);

        return $plainToken;
    }
}
