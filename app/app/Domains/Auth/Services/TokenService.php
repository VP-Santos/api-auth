<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Exceptions\VerificationAlreadySentException;

class TokenService
{
    public function ensureNoActiveToken(string $model, int $userId): void
    {
        $token = $this->getActiveToken($model, $userId);

        if ($token?->expires_at > now()) {
            throw new VerificationAlreadySentException($token->expires_at);
        }

        if ($token) {
            $token->delete();
        }
    }

    public function getActiveToken(string $model, int $userId): ?object
    {
        return $this->getActiveTokenRecord($model, $userId);
    }

    private function getActiveTokenRecord(string $model, int $userId): ?object
    {
        return $model::where('user_id', $userId)
            ->latest()
            ->first();
    }
}
