<?php

namespace App\Services;


use App\Exceptions\Auth\{
    InvalidTokenException,
};

use App\Models\{
    EmailVerification,
    User
};

class EmailVerificationService
{
    public function verify(string $token): string
    {
        $record = EmailVerification::where('token', $token)->first();

        if (!$record) {
            throw new InvalidTokenException('Token is invalid or has already been used.');
        }

        if ($record->expires_at < now()) {
            throw new InvalidTokenException('Token has expired.');
        }

        $user = User::findOrFail($record->user_id);

        if ($user->email_verified_at) {
            throw new InvalidTokenException('Email has already been verified.', 409);
        }

        $user->update([
            'email_verified_at' => now(),
            'status' => 'actived'
        ]);

        $token = $user->createToken('access', [$user->access_level])->plainTextToken;

        $user->update([
            'current_token' => $token
        ]);

        $record->delete();

        return $token;
    }
}