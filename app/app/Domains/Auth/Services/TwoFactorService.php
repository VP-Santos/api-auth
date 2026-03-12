<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    FlowException,
    InvalidTokenException,
    InvalidTwoFactorCodeException,
    VerificationAlreadySentException
};

use App\Domains\Auth\Actions\CreateTwoFactorVerification;
use App\Domains\Auth\Events\TwoFactorRegistered;
use App\Domains\Auth\Models\TwoFactor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TwoFactorService
{
    public function __construct(
        private CreateTwoFactorVerification $createTwoFactorVerification
    ) {}
    public function verify(array $data): string
    {
        return DB::transaction(function () use ($data) {
            $user = User::where('email', $data['email'])->firstOrFail();

            $twoFactor = TwoFactor::where('user_id', $user->id)
                ->lockForUpdate()
                ->latest()
                ->first();

            if (!$twoFactor) {
                throw new InvalidTwoFactorCodeException();
            }

            if ($twoFactor->expires_at < now()) {
                throw new InvalidTwoFactorCodeException();
            }

            if (!hash_equals($twoFactor->code, $data['code'])) {
                throw new InvalidTwoFactorCodeException();
            }

            $token = $user->createToken('access', [$user->access_level])->plainTextToken;

            $twoFactor->delete();

            return  $token;
        });
    }

    public function ensureNoActiveCode(int $userId): void
    {
        $twoFactor = TwoFactor::where('user_id', $userId)->first();

        if ($twoFactor?->expires_at > now()) {

            $secondsRemaining = now()->diffInSeconds($twoFactor->expires_at);
            $time = gmdate('i:s', $secondsRemaining);

            throw new VerificationAlreadySentException(
                "Verification code already sent. Please wait {$time} seconds."
            );
        }

        if ($twoFactor) {
            $twoFactor->delete();
        }
    }

    public function resend(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException();
            }

            $record = TwoFactor::where('user_id', '=', $user->id)->first();

            if (!$record) {
                throw new FlowException();
            }

            if ($record->expires_at > now()) {

                $secondsRemaining = now()->diffInSeconds($record->expires_at);

                $time = gmdate('i:s', $secondsRemaining);
                throw new VerificationAlreadySentException(
                    "Verification token already sent. Please wait {$time} seconds before requesting a new one."
                );
            }

            $record->delete();

            $token = $this->createTwoFactorVerification->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                TwoFactorRegistered::dispatch($user, $token);
            });
        });
    }
}
