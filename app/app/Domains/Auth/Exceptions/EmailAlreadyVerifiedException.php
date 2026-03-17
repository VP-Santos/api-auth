<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class EmailAlreadyVerifiedException extends AbstractApiException
{
    protected int $httpCode = 409;
    protected string $errorCode = 'EMAIL_ALREADY_VERIFIED';

    public function __construct(
        string $message = 'This email has already been verified.'
    ) {
        parent::__construct($message);
    }
}