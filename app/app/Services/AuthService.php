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
    InvalidTokenException,
    LoginException,
    VerificationAlreadySentException,
};
use App\Models\PasswordReset;
use App\Models\TwoFactor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\{
    DB,
    Hash
};

use function Symfony\Component\Clock\now;

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

            app(VerificationService::class)->getTwoFactorExists($user->id);

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException;
            }

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

    public function ForgetPassword(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();


            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException;
            }

            app(VerificationService::class)->getTokenExists($user->id);


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

    public function resendTokenPassword($email)
    {
        DB::transaction(function () use ($email) {

            $user = User::where($email)->first();

            if (!$user->email_verified_at) {
                throw new InvalidTokenException('Email has already been verified.', 409);
            }

            $record = PasswordReset::where('user_id', '=', $user->id)->latest()->first();

            if ($record->expires_at > Carbon::now()) {

                $secondsRemaining = Carbon::now()->diffInSeconds($record->expires_at);

                $time = gmdate('i:s', $secondsRemaining);
                throw new VerificationAlreadySentException(
                    "Verification token already sent. Please wait {$time} seconds before requesting a new one."
                );
            }

            $record->delete();

            $token = app(CreatePasswordReset::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }
    public function resendTwoFactorEmail($email)
    {
        DB::transaction(function () use ($email) {

            $user = User::where($email)->first();

            if (!$user->email_verified_at) {
                throw new InvalidTokenException('Email has already been verified.', 409);
            }

            $record = TwoFactor::where('user_id', '=', $user->id)->first();

            if ($record->expires_at > Carbon::now()) {

                $secondsRemaining = Carbon::now()->diffInSeconds($record->expires_at);

                $time = gmdate('i:s', $secondsRemaining);
                throw new VerificationAlreadySentException(
                    "Verification token already sent. Please wait {$time} seconds before requesting a new one."
                );
            }

            $record->delete();
            $token = app(CreateEmailVerification::class)->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                EmailVerificationRequested::dispatch($user, $token);
            });
        });
    }
}
