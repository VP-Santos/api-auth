<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\{
    EmailAlreadyVerifiedException,
    ExpiredTokenException,
    InvalidTokenException,
};

use App\Domains\Auth\Models\EmailVerification;
use App\Models\User;

class EmailVerificationService
{
    public function __construct() {}
    public function verify(string $token): string
    {
        $record = EmailVerification::where('token', $token)->first();

        if (!$record) {
            throw new InvalidTokenException();
        }

        $user = User::find($record->user_id);

        $user->update([
            'email_verified_at' => now(),
            'status' => 'actived'
        ]);

        $token = $user->createToken('access', [$user->access_level])->plainTextToken;

        $record->delete();

        return $token;
    }
}
