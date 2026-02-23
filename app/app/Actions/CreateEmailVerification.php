<?php

namespace App\Actions;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Support\Str;

class CreateEmailVerification
{
    public function execute(User $user): string
    {
        $plainToken = Str::random(64);

        EmailVerification::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addMinutes(30),
        ]);

        return $plainToken;
    }
}
