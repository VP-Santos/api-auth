<?php

namespace App\Actions;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;

class CreatePasswordReset
{
    public function execute(User $user): string
    {
        $plainToken = hash('sha256', Str::random(64));

        PasswordReset::create([
            'user_id' => $user->id,
            'token' => $plainToken,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $plainToken;
    }
}