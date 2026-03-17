<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class EmailNotVerifiedException extends AbstractApiException
{
    protected int $httpCode = 403;
    protected string $errorCode = 'EMAIL_NOT_VERIFIED';

    public function __construct(string $message = 'Email not verified.')
    {
        parent::__construct($message);
    }
}
