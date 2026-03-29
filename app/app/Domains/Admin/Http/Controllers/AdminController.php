<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Domains\Admin\Http\Requests\FormUpdateUserRequest;
use App\Domains\Admin\Services\AdminUserService;
use App\Domains\Admin\Services\BanUserService;
use App\Domains\Admin\Services\PrometeUserService;

class AdminController
{
    public function __construct(
        public AdminUserService $adminUserServce,
        public BanUserService $banUserService,
        public PrometeUserService $prometeUserService 
    ) {}

    /**
     * Summary of getAllUsers
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers()
    {

        $all = $this->adminUserServce->getAllUsers();

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'users' => $all
        ], 200);
    }

    /**
     * Summary of getUser
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(int $id)
    {
        $user = $this->adminUserServce->getUser($id);

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'user' => $user
        ], 200);
    }

    /**
     * Summary of updateUser
     * @param \App\Domains\Admin\Http\Requests\FormUpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Summary of deleteUser
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
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
        $user = $this->banUserService->ban($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} banned successfully.",
        ], 200);
    }
    public function unBanUser(int $id)
    {
        $user = $this->banUserService->unBan($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} banned successfully.",
        ], 200);
    }

    public function promoteUser(int $id)
    {
        $user = $this->prometeUserService->promote($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$user->user_name} promoted to admin successfully.",
        ], 200);
    }


    public function demoteUser(int $id)
    {
        $id = $this->prometeUserService->demote($id);

        return response()->json([
            'success'   => true,
            'message'   => "User {$id} demoted to user successfully.",
        ], 200);
    }
}
