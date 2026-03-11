<?php

namespace App\Services;

use App\Actions\{
    CreateEmailVerification,
    CreatePasswordReset,
    CreateTwoFactorVerification
};
use App\Events\{
    EmailVerificationRequested,
    ForgotPassword,
    TwoFactorRegistered,
};
use App\Exceptions\Auth\{
    EmailNotVerifiedException,
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
        private PasswordResetService $passwordResetService
    ) {}
    public function registerUser(array $data)
    {
        DB::transaction(function () use ($data) {

            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = null;

            $user = User::create($data);

            $token = app(CreateEmailVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                EmailVerificationRequested::dispatch($user, $token);
            });
        });
    }
    public function login(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new LoginException;
            }
            
            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException;
            }
            
            $this->twoFactorService->ensureNoActiveCode($user->id);


            $code = app(CreateTwoFactorVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $code) {
                TwoFactorRegistered::dispatch($user, $code);
            });
        });
    }
    public function updateUser(array $dataUpdate, User $user)
    {
        DB::transaction(function () use ($dataUpdate, $user) {

            $emailChanged = $user->email !== $dataUpdate['email'];

            $user->update($dataUpdate);

            if ($emailChanged) {

                $user->email_verified_at = null;
                $user->save();

                $token = app(CreateEmailVerification::class)->execute($user);

                DB::afterCommit(function () use ($user, $token) {
                    EmailVerificationRequested::dispatch($user, $token);
                });
            }
        });
    }

    public function forgetPassword(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();


            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException;
            }

            $this->passwordResetService->ensureNoActiveToken($user->id);


            $token = app(CreatePasswordReset::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }

    public function updatePassword(array $data, User $user)
    {
        $user->password = Hash::make($data['password']);
        $user->save();
    }
}
