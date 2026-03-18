<?php

namespace App\Domains\Auth\Exceptions;

use App\Exceptions\AbstractApiException;

class FlowException extends AbstractApiException
{
    protected int $httpCode = 400;
    protected string $errorCode = 'FLOW_INVALID';

    public function __construct(
        string $flow = 'login'
    ) {
        parent::__construct("Cannot resend token. Please start the {$flow} flow first.");
    }
}