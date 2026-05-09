<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Resources\AdminResource;
use App\Domains\Admin\Services\BanUserService;
use App\Http\Controllers\Controller;

class AdminBanController extends Controller
{
    public function __construct(
        public BanUserService $banUserService,
    ) {}

  public function banUser(int $id)
  {
    $user = $this->banUserService->ban($id);

    return $this->success(
      "User {$user->name} banned successfully.",
      new AdminResource($user)

    );
  }
  public function unBanUser(int $id)
  {
    $user = $this->banUserService->unBan($id);

    return $this->success(
      "User {$user->name} unbanned successfully.",
      new AdminResource($user)

    );
  }
}
