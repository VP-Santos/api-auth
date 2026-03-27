<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Requests\FormUpdateUserRequest;
use App\Domains\Admin\Services\AdminUserService;

class AdminController
{
    public function __construct(public AdminUserService $adminUserServce) {}
    public function getAllUsers()
    {

        $all = $this->adminUserServce->getAllUsers();

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'users' => $all
        ], 200);
    }


    public function getUser(int $id)
    {
        $user = $this->adminUserServce->getUser($id);

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'user' => $user
        ], 200);
    }

    public function updateUser(FormUpdateUserRequest $request, int $id)
    {
        $data = $request->validated();

        $user = $this->adminUserServce->updateUser($id, $data);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} updated successfully.",
            'data'      => $user,
        ], 200);
    }

    public function deleteUser(int $id)
    {
        $user_name = $this->adminUserServce->deleteUser($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user_name} deleted successfully.",
        ], 200);
    }
    public function banUser(int $id)
    {
        $user = $this->adminUserServce->banUser($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} banned successfully.",
        ], 200);
    }
    public function promoteUser(int $id)
    {
        $user = $this->adminUserServce->promoteUser($id, 'adm');

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} promoted to admin successfully.",
        ], 200);
    }
}
