<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Resources\AdminResource;
use App\Domains\Admin\Services\RoleUserService;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
  public function __construct(
    public RoleUserService $roleUserService
  ) {}


  public function promoteUser(int $id)
  {
    $user = $this->roleUserService->promote($id);

    return $this->success(
      "User {$user->name} promoted to admin successfully.",
      new AdminResource($user)

    );
  }

  public function demoteUser(int $id)
  {

    $user = $this->roleUserService->demote($id);

    return $this->success(
      "User {$user->name} demoted to user successfully.",
      new AdminResource($user)
    );
  }
}
