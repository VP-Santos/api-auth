<?php

namespace App\Domains\Admin\Exceptions;

use App\Exceptions\AbstractApiException;

class InvalidUserStateException extends AbstractApiException
{
    protected int $httpCode = 409;
    protected string $errorCode = 'CONFLICT';

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}