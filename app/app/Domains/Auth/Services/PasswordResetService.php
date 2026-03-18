<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Actions\CreatePasswordReset;
use App\Domains\Auth\Events\ForgotPassword;
use App\Models\User;
use App\Domains\Auth\Models\PasswordReset;

use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    ExpiredTokenException,
    FlowException,
    InvalidTokenException,
    SamePasswordException,
};

use Illuminate\Support\Facades\{
    DB,
    Hash
};

class PasswordResetService
{
    public function __construct(
        private CreatePasswordReset $createPasswordReset,
        private TokenService $tokenService
    ) {}
    public function verify(array $data): void
    {
        DB::transaction(function () use ($data) {

            $record = PasswordReset::where('token', $data['token'])->first();

            if (!$record) {
                throw new InvalidTokenException();
            }

            if ($record->expires_at < now()) {
                throw new  ExpiredTokenException();
            }

            $user = User::find($record->user_id);

            if (Hash::check($data['password'], $user?->password)) {
                throw new SamePasswordException();
            }

            $user->update([
                'password' => Hash::make($data['password'])
            ]);

            $record->delete();
        });
    }

    public function checkTokenState(int $userId): void
    {

        $this->tokenService->ensureNoActiveToken(PasswordReset::class, $userId);
    }
    public function resend(array $data): void
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException();
            }

            $tokenActive = $this->getActiveToken($user->id);

            if ($tokenActive) {
                throw new FlowException();
            }

            $this->checkTokenState($user->id);

            $token = $this->createPasswordReset->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }

    public function getActiveToken(int $userId)
    {
        return $this->tokenService->getActiveToken(PasswordReset::class, $userId);
    }
}
