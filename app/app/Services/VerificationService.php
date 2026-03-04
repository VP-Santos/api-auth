<?php

namespace App\Services;

use App\Models\{
    EmailVerification,
    TwoFactor,
    User
};
use Illuminate\Support\Facades\DB;

class VerificationService
{
    public function verifyTokenEmail(string $token)
    {
        $tokenCreated = null;

        DB::transaction(function () use ($token, &$tokenCreated) {

            $record = EmailVerification::where('token', $token)->first();

            if (!$record || $record->expires_at < now()) {
                throw new \App\Exceptions\Auth\InvalidTokenException();
            }

            $user = User::findOrFail($record->user_id);
            $user->email_verified_at = now();
            $user->status = 'actived';

            $abilities = [$user->access_level];
            $tokenCreated = $user->createToken('access', $abilities)->plainTextToken;
            $user->current_token = $tokenCreated;
            $user->save();
        });

        return $tokenCreated;
    }

    public function verifyTwoFactor(array $data)
    {

        $user = User::where('email', '=', $data['email'])
            ->firstOrFail();

        $twoFactor = TwoFactor::where('user_id', '=', $user->id)
            ->firstOrFail();

        if (now() > $twoFactor->expires_at || !hash_equals($twoFactor->code, $data['code'])) {
            throw new \App\Exceptions\Auth\InvalidTwoFactorCodeException;
        }

        $abilities = [$user->access_level];
        $token = $user->createToken('access', $abilities)->plainTextToken;
        $user->current_token = $token;
        $user->save();

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function verifyResetPassword(array $data) {}
}
