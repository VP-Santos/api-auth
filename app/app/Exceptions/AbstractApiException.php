<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;

abstract class AbstractApiException extends Exception
{
    use ApiResponse;
    protected int $httpCode = 400;
    protected string $errorCode = 'API_ERROR';

    public function render()
    {
        return $this->error(
            $this->errorCode,
            $this->getMessage(),
            $this->httpCode
        );
    }
}
