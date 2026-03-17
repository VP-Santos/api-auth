<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class ExpiredTokenException extends AbstractApiException
{
    protected int $httpCode = 401;
    protected string $errorCode = 'TOKEN_INVALID';

    public function __construct(string $message = 'Invalid or expired token.')
    {
        parent::__construct($message);
    }
}
