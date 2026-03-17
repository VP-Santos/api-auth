<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class SamePasswordException extends AbstractApiException
{
    protected int $httpCode = 422;
    protected string $errorCode = 'SAME_PASSWORD';

    public function __construct(
        string $message = 'The new password cannot be the same as the current password.'
    ) {
        parent::__construct($message);
    }
}