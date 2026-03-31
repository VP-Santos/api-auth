<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    ExpiredTokenException,
    FlowException,
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
        private TokenService $tokenService

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
            
            $user->tokens()->delete();

            $token = $user->createToken('access', [$user->access_level])->plainTextToken;

            $twoFactor->delete();

            return  $token;
        });
    }

    public function checkTwoFactorState(int $userId): void
    {
        $this->tokenService->ensureNoActiveToken(TwoFactor::class, $userId);
    }


    public function resend(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException();
            }

            $tokenActive = $this->getActiveTwoFactor($user->id);

            if (!$tokenActive) {
                throw new FlowException();
            }

            $this->checkTwoFactorState($user->id);

            $code = $this->createTwoFactorVerification->execute($user);

            DB::afterCommit(function () use ($user, $code) {
                TwoFactorRegistered::dispatch($user, $code);
            });

            return $code;
        });
    }

    public function getActiveTwoFactor(int $userId)
    {
        return $this->tokenService->getActiveToken(TwoFactor::class, $userId);
    }
}
