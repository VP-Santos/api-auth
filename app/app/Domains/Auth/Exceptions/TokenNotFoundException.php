<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class TokenNotFoundException extends AbstractApiException
{
    protected int $httpCode = 404;
    protected string $errorCode = 'TOKEN_NOT_FOUND';

    public function __construct(string $message = 'Token not found.')
    {
        parent::__construct($message);
    }
}
