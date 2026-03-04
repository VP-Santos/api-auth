<?php

namespace App\Services;

use App\Actions\{
    CreateEmailVerification,
    CreateTwoFactorVerification
};
use App\Events\{
    ForgotPassword,
    TwoFactorRegistered,
    UserRegistered
};
use App\Exceptions\Auth\{
    EmailNotVerifiedException,
    LoginException
};
use App\Models\User;
use Illuminate\Support\Facades\{
    DB,
    Hash
};


class AuthService
{
    public function registerUser(array $data)
    {
        DB::transaction(function () use ($data) {

            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = null;

            $user = User::create($data);

            $token = app(CreateEmailVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                UserRegistered::dispatch($user, $token);
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

            $code = app(CreateTwoFactorVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $code) {
                TwoFactorRegistered::dispatch($user, $code);
            });
        });
        return '';
    }

    public function updateUser(array $dataUpdate, User $user)
    {
        dd($dataUpdate, $user);
    }

    public function ForgetPassword(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->firstOrFail();
            if ($user->email_verified_at) {

                throw new EmailNotVerifiedException;
            }
            $token = app(CreateEmailVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }
}
