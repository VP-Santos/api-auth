<?php

namespace App\Services;

use App\Exceptions\Auth\InvalidTokenException;
use App\Exceptions\Auth\SamePasswordException;
use App\Models\{
    EmailVerification,
    PasswordReset,
    TwoFactor,
    User
};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerificationService
{
    public function verifyTokenEmail(string $token)
    {
        $tokenCreated = null;

        DB::transaction(function () use ($token, &$tokenCreated) {

            $record = EmailVerification::where('token', $token)->first();

            if (!$record) {
                throw new \App\Exceptions\Auth\InvalidTokenException('Token is invalid or has already been used.');
            }

            if ($record->expires_at < now()) {
                throw new \App\Exceptions\Auth\InvalidTokenException('Token has expired.');
            }

            $user = User::findOrFail($record->user_id);

            if ($user->email_verified_at) {
                throw new \App\Exceptions\Auth\InvalidTokenException('Email has already been verified.', 409);
            }

            $user->email_verified_at = now();
            $user->status = 'actived';

            $abilities = [$user->access_level];
            $tokenCreated = $user->createToken('access', $abilities)->plainTextToken;
            $user->current_token = $tokenCreated;
            $user->save();

            $record->delete();
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
            'token' => $token
        ];
    }
    public function verifyResetPassword(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', '=', $data['email'])->firstOrFail();

            $token = $data['token'];

            $record = PasswordReset::where('token', '=', $token)->firstOrFail();

            if ($record->expires_at < now()) {
                throw new InvalidTokenException('Token has expired.');
            }

            $data['password'] = Hash::make($data['password']);

        if (Hash::check($data['password'], $user->password)) {
            throw new SamePasswordException;
        }

            $user->update(['password' => $data['password']]);
        });
    }
}
