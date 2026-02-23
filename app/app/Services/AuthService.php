<?php

namespace App\Services;

use App\Actions\CreateEmailVerification;
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
        return DB::transaction(function () use ($data) {

            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = null;

            $user = User::create($data);

            $token = app(CreateEmailVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                UserRegistered::dispatch($user, $token);
            });

            return $user;
        });
    }
    public function login() {}
}
