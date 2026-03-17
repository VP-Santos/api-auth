<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Actions\CreatePasswordReset;
use App\Domains\Auth\Events\ForgotPassword;
use App\Models\User;
use App\Domains\Auth\Models\PasswordReset;

use App\Domains\Auth\Exceptions\{
    EmailNotVerifiedException,
    ExpiredTokenException,
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
        private TokenThrottleService $tokenThrottleService
    ) {}
    public function reset(array $data): void
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
        
        $this->tokenThrottleService->ensureNoActiveToken(PasswordReset::class, $userId);
    }
    public function resend(array $data): void
    {
        DB::transaction(function () use ($data) {

            $user = User::where('email', $data['email'])->first();

            if (!$user->email_verified_at) {
                throw new EmailNotVerifiedException();
            }

            $this->checkTokenState($user->id);

            $token = $this->createPasswordReset->execute($user);

            DB::afterCommit(function () use ($user, $token) {
                ForgotPassword::dispatch($user, $token);
            });
        });
    }
}
