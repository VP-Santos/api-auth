<?php

namespace App\Domains\Auth\Exceptions;

use Exception;

abstract class AbstractException extends Exception
{
    protected int $httpCode;

    public function __construct(
        string $message = "internal server error",
        int $httpCode = 500
    ) {
        parent::__construct($message);
        $this->httpCode = $httpCode;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
