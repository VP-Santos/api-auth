<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class FlowException extends AbstractApiException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'FLOW_INVALID';

    public function __construct(
        string $message = 'Cannot resend token. Please start the login flow first.'
    ) {
        parent::__construct($message);
    }
}