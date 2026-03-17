<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class VerificationAlreadySentException extends AbstractApiException
{
    protected int $httpCode = 429;
    protected string $errorCode = 'VERIFICATION_ALREADY_SENT';

    public function __construct(string $expiresAt)
    {
        $secondsRemaining = now()->diffInSeconds($expiresAt);
        $time = gmdate('i:s', $secondsRemaining);

        parent::__construct(
            "Verification token already sent. Please wait {$time} seconds."
        );
    }
}
