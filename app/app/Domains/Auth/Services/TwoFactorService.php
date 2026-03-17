<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    ExpiredTokenException,
    InvalidTokenException,
    TokenNotFoundException,
};

use App\Domains\Auth\Actions\CreateTwoFactorVerification;
use App\Domains\Auth\Events\TwoFactorRegistered;
use App\Domains\Auth\Models\TwoFactor;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TwoFactorService
{
    public function __construct(
        private CreateTwoFactorVerification $createTwoFactorVerification,
        private TokenThrottleService $tokenThrottleService

    ) {}
    public function verify(array $data): string
    {
        return DB::transaction(function () use ($data) {
            $user = User::where('email', $data['email'])->first();

            $twoFactor = TwoFactor::where('user_id', $user->id)
                ->lockForUpdate()
                ->latest()
                ->first();

            if (!$twoFactor) {
                throw new TokenNotFoundException();
            }

            if ($twoFactor->expires_at < now()) {
                throw new ExpiredTokenException();
            }

            if (!hash_equals($twoFactor->code, $data['code'])) {
                throw new InvalidTokenException();
            }

            $token = $user->createToken('access', [$user->access_level])->plainTextToken;

            $twoFactor->delete();

            return  $token;
        });
    }

    public function checkTwoFactorState(int $userId): void
    {
        $this->tokenThrottleService->ensureNoActiveToken(TwoFactor::class, $userId);
    }


    public function resend(array $data): void
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException();
            }

            app(TokenThrottleService::class)
                ->ensureNoActiveToken(TwoFactor::class, $user->id);

            $token = $this->createTwoFactorVerification->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                TwoFactorRegistered::dispatch($user, $token);
            });
        });
    }
}
