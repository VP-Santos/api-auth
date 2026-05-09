<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Exceptions\InvalidUserStateException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BaseService
{
  use AuthorizesRequests;

  public function __construct(

    protected UserRepository $userRepository,
  ) {}

  public function authorizeUserActionById(int $id)
  {
    $user = $this->userRepository->findOrFail($id);

    $this->authorize('thisAction', $user);

    return $user;
  }
  public function authorizeUserAction(User $user)
  {
    $this->authorize('thisAction', $user);

    return $user;
  }

  protected function ensureUserIsNotBanned(User $user): void
  {
    if ($user->is_banned) {
      throw new InvalidUserStateException(
        'Banned users cannot receive this action.'
      );
    }
  }
}
