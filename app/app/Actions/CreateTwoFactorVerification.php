<?php

namespace App\Actions;

use App\Models\TwoFactor;
use App\Models\User;

class CreateTwoFactorVerification
{
    public function execute(User $user): string
    {
        $code = str_pad(
            mt_rand(0, 999999),
            6,
            '0',
            STR_PAD_LEFT
        );

        TwoFactor::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(2),
        ]);

        return $code;
    }
}
