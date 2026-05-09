<?php

namespace App\Domains\Admin\Services;

use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BaseService
{
  use AuthorizesRequests;

  public function __construct(

    protected UserRepository $userRepository,
  ) {}

  public function targetUserAction(int $id)
  {
    $user = $this->userRepository->findOrFail($id);

    $this->authorize('thisAction', $user);
    
  }
}
