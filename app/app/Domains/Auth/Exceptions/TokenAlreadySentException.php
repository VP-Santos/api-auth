<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class TokenAlreadySentException extends AbstractApiException
{
    protected int $httpCode = 429;
    protected string $errorCode = 'EMAIL_ALREADY_SENT';

    public function __construct(
    ) {
        parent::__construct('A verification email has already been sent. Please wait before requesting another.');
    }
}