<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;
use Exception;

class LoginException extends AbstractApiException
{
    protected int $httpCode = 401;
    protected string $errorCode = 'CREDENTIALS_INVALID';

    public function __construct(
        string $message = 'Incorrect email or password.'
    ) {
        parent::__construct($message);
    }
}
