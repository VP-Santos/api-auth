<?php

namespace App\Exceptions;

class BannedUserException extends AbstractApiException
{
    protected int $httpCode = 403;
    protected string $errorCode = 'USER_BANNED';

    public function __construct(string $message = 'This account has been banned.')
    {
        parent::__construct($message);
    }
}