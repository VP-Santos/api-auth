<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Exceptions\InvalidUserStateException;
use App\Models\User;

abstract class UserActionService extends BaseService
{

  protected function executeAction(
    User $user,
    string $field,
    mixed $expectedValue,
    object $action,
    string $message
  ) {
    $this->authorizeUserAction($user);

    if ($user->{$field} !== $expectedValue) {
      return $action->execute($user);
    }

    throw new InvalidUserStateException($message);
  }
}
