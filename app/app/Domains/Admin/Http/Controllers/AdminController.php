<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Requests\FormUpdateUserRequest;
use App\Domains\Admin\Http\Resources\AdminResource;
use App\Domains\Admin\Services\AdminUserService;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function __construct(
        public AdminUserService $adminUserServce,
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

}
