<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Requests\FormUpdateUserRequest;
use App\Domains\Admin\Http\Resources\AdminResource;
use App\Domains\Admin\Services\AdminUserService;
use App\Domains\Admin\Services\BanUserService;
use App\Domains\Admin\Services\PrometeUserService;
use App\Traits\ApiResponse;

class AdminController
{

    use ApiResponse;
    public function __construct(
        public AdminUserService $adminUserServce,
        public BanUserService $banUserService,
        public PrometeUserService $prometeUserService
    ) {}


    public function getAllUsers()
    {

        $all = $this->adminUserServce->getAllUsers();

        return $this->success(
            'Users retrieved successfully.',
            AdminResource::collection($all)
        );
    }


    public function getUser(int $id)
    {
        $user = $this->adminUserServce->getUser($id);

        return $this->success(
            'User retrieved successfully.',
            new AdminResource($user)
        );
    }


    public function updateUser(FormUpdateUserRequest $request, int $id)
    {
        $data = $request->validated();

        $user = $this->adminUserServce->updateUser($id, $data);

        return $this->success(
            "User {$user->name} updated successfully.",
            new AdminResource($user)
        );
    }

    public function deleteUser(int $id)
    {
        $user = $this->adminUserServce->deleteUser($id);

        return $this->success(
            "User {$user->name} deleted successfully.",
            new AdminResource($user)

        );
    }


    //TODO colocar regra para banir uma unica vez e para as demais funções abaixo
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
            "User {$user->name} banned successfully.",
            new AdminResource($user)

        );
    }

    public function promoteUser(int $id)
    {
        $user = $this->prometeUserService->promote($id);

        return $this->success(
            "User {$user->name} promoted to admin successfully.",
            new AdminResource($user)

        );
    }


    public function demoteUser(int $id)
    {
        $user = $this->prometeUserService->demote($id);

        return $this->success(
            "User {$user->name} demoted to user successfully.",
            new AdminResource($user)
        );
    }
}
