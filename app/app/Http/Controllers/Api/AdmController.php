<?php

namespace App\Http\Controllers\Api;

use App\Domains\Admin\Services\AdminUserService;
use App\Http\Requests\Adm\FormDeleteUserRequest;
use App\Http\Requests\Adm\FormGetUserRequest;
use App\Http\Requests\Adm\FormUpdateUserRequest;
use App\Repositories\UserRepository;

class AdmController
{
    public function __construct(public AdminUserService $adminUserServce) {}
    public function getAllUsers()
    {

        $all = $this->adminUserServce->getAllUsers();

        return response()->json([
            'success' => true,
            'users' => $all
        ], 200);
    }


    public function getUser($id)
    {
        $userModel = $this->adminUserServce->getUser($id);

        if ($userModel) {
            $response = $userModel;
            $statusCode = 200;
        }

        return response()->json($response, $statusCode);
    }

    public function updateUser(FormUpdateUserRequest $request, $id)
    {
        $data = $request->validated();

        $user = $this->adminUserServce->updateUser($id, $data);

        // return response()->json([
        //     $response
        // ], $statusCode);
    }

    public function deleteUser($id)
    {
        $this->adminUserServce->deleteUser($id);

        // return response()->json($response, $statusCode);

    }
    public function banUser($id)
    {
        $this->adminUserServce->banUser($id);

        // return response()->json($response, $statusCode);

    }
    public function promoteUser($id)
    {
        $this->adminUserServce->promoteUser($id, '');

        // return response()->json($response, $statusCode);

    }
}
