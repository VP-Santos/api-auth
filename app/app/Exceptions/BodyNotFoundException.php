<?php

namespace App\Exceptions;

class BodyNotFoundException extends AbstractApiException
{
    protected int $httpCode = 404;
    protected string $errorCode = 'BODY_NOT_FOUND';

    public function __construct(string $message = 'Body not found.')
    {
        parent::__construct($message);
    }
}