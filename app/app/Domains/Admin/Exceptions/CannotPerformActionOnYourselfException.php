<?php

namespace App\Domains\Admin\Exceptions;

use App\Exceptions\AbstractApiException;

class CannotPerformActionOnYourselfException extends AbstractApiException
{
    protected int $httpCode = 403;
    protected string $errorCode = 'USER_BANNED';

    public function __construct(string $message = 'You cannot perform this action on yourself.')
    {
        parent::__construct($message);
    }
}