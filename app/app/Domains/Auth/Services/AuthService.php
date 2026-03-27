<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Actions\{
    CreateEmailVerification,
    CreatePasswordReset,
    CreateTwoFactorVerification
};
use App\Domains\Auth\Events\{
    EmailVerificationRequested,
    ForgotPassword,
    TwoFactorRegistered,
};
use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    TokenAlreadySentException,
    LoginException,
};
use App\Models\User;
use Illuminate\Support\Facades\{
    DB,
    Hash
};

class AuthService
{
    public function __construct(
        private TwoFactorService $twoFactorService,
        private PasswordResetService $passwordResetService,
        private CreateEmailVerification $createEmailVerification,
        private CreateTwoFactorVerification $createTwoFactorVerification,
        private CreatePasswordReset $createPasswordReset
    ) {}
    public function registerUser(array $data)
    {
        return  DB::transaction(function () use ($data) {

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $token = $this->createEmailVerification->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                EmailVerificationRequested::dispatch($user, $token);
            });

            return $token;
        });
    }
    public function login(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->lockForUpdate()->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new LoginException;
            }

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException;
            }

            $tokenActive = $this->twoFactorService->getActiveTwoFactor($user->id);

            if ($tokenActive?->expires_at > now()) {
                throw new TokenAlreadySentException();
            }

            $code = $this->createTwoFactorVerification->execute($user);

            DB::afterCommit(function () use ($user, $code) {
                TwoFactorRegistered::dispatch($user, $code);
            });
            return $code;
        });
    }
    public function forgetPassword(array $data)
    {

        $user = User::where('email', $data['email'])->lockForUpdate()->first();

        if (!$user->email_verified_at) {
            throw new EmailNotVerifiedException;
        }

        return DB::transaction(function () use ($user) {

            $tokenActive = $this->passwordResetService->getActiveToken($user->id);

            if ($tokenActive?->expires_at > now()) {
                throw new TokenAlreadySentException();
            }
            $token = $this->createPasswordReset->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });

            return $token;
        });
    }
}
