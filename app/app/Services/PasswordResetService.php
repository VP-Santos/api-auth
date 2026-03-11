<?php

namespace App\Services;

use App\Actions\CreatePasswordReset;
use App\Events\ForgotPassword;
use App\Exceptions\Auth\{
    InvalidTokenException,
    SamePasswordException,
    VerificationAlreadySentException
};

use App\Models\{
    PasswordReset,
    User
};
use Illuminate\Support\Facades\{
    DB,
    Hash
};

class PasswordResetService
{
    public function __construct(
        private CreatePasswordReset $createPasswordReset
    ) {}
    public function reset(array $data): void
    {
        DB::transaction(function () use ($data) {

            $record = PasswordReset::where('token', $data['token'])->first();

            if (!$record) {
                throw new InvalidTokenException('Token not found.');
            }

            if ($record->expires_at < now()) {
                throw new InvalidTokenException('Token has expired.');
            }

            $user = User::findOrFail($record->user_id);

            if (Hash::check($data['password'], $user->password)) {
                throw new SamePasswordException();
            }

            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            $record->delete();
        });
    }

    public function ensureNoActiveToken(int $userId): void
    {
        $token = PasswordReset::where('user_id', $userId)->first();

        if ($token?->expires_at > now()) {

            $secondsRemaining = now()->diffInSeconds($token->expires_at);
            $time = gmdate('i:s', $secondsRemaining);

            throw new VerificationAlreadySentException(
                "Verification token already sent. Please wait {$time} seconds."
            );
        }

        if ($token) {
            $token->delete();
        }
    }

    public function resend(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new InvalidTokenException('Email has already been verified.', 409);
            }

            $record = PasswordReset::where('user_id', '=', $user->id)->latest()->first();

            if ($record->expires_at > now()) {

                $secondsRemaining = now()->diffInSeconds($record->expires_at);

                $time = gmdate('i:s', $secondsRemaining);
                throw new VerificationAlreadySentException(
                    "Verification token already sent. Please wait {$time} seconds before requesting a new one."
                );
            }

            $record->delete();

            $token = $this->createPasswordReset->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }
}
