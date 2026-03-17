<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\VerificationAlreadySentException;

class TokenThrottleService
{
    public function ensureNoActiveToken(string $model, int $userId): void
    {
        $token = $model::where('user_id', $userId)->latest()->first();

        if ($token?->expires_at > now()) {
            throw new VerificationAlreadySentException($token->expires_at);
        }

        if ($token) {
            $token->delete();
        }
    }
}
