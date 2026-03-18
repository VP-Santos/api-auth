<?php

namespace App\Domains\Admin\Exceptions;

use App\Exceptions\AbstractApiException;

class UserNotFoundException extends AbstractApiException
{
    protected int $httpCode = 404;
    protected string $errorCode = 'USER_NOT_FOUND';

    public function __construct(int $id)
    {
        parent::__construct("The user with ID $id was not found.");
    }
}