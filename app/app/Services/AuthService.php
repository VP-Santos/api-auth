<?php

namespace App\Services;

use App\Actions\CreateEmailVerification;
use App\Actions\CreateTwoFactorVerification;
use App\Events\TwoFactorRegistered;
use App\Events\UserRegistered;
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
                throw new \App\Exceptions\Auth\LoginException;
            }

            if (!$user->email_verified_at) {
                throw new \App\Exceptions\Auth\EmailNotVerifiedException;
            }

            $code = app(CreateTwoFactorVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $code) {
                TwoFactorRegistered::dispatch($user, $code);
            });
        });
        return '';
    }

    public function updateUser(array $fieldsUpdate, User $user)
    {
        dd($fieldsUpdate, $user);
    }
}
