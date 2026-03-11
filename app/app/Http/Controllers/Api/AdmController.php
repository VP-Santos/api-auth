<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Adm\FormDeleteUserRequest;
use App\Http\Requests\Adm\FormGetUserRequest;
use App\Http\Requests\Adm\FormUpdateUserRequest;
use App\Repositories\UserRepository;

class AdmController
{
    protected $repository;
    
    public function getAllUsers()
    {
        $adms = [];
        $users = [];

        $all = $this->repository->getAll();

        foreach ($all as $value) {
            if ($value['access_level'] === 'adm') {
                $adms[] = $value;
                continue;
            }
            $users[] = $value;
        }

        return response()->json([
            'adms' => $adms,
            'users' => $users
        ], 200);
    }


    public function getUser($id)
    {
        $userId = ['id' => $id];


        $response = ['message' => 'User not found'];
        $statusCode = 404;

        $userModel = $this->repository->getUser($userId);

        if ($userModel) {
            $response = $userModel;
            $statusCode = 200;
        }

        return response()->json($response, $statusCode);
    }

    public function updateUser(FormUpdateUserRequest $request, $id)
    {
        $data = $request->validated();

        $userFind = $this->repository->getUser(['id' => $id]);

        $response = ['message' => 'User not found'];
        $statusCode = 404;

        if ($userFind) {
            $user = $this->repository->updateUser(['id' => $id], $data);
            $response = [
                'message' => 'usuario atualizado',
                'user' => $user
            ];
            $statusCode = 404;
        }

        return response()->json([
            $response
        ], $statusCode);
    }

    public function deleteUser($id)
    {   
        try{
            $userId = ['id' => $id];
            
            $response = ['message' => 'User not found'];
            $statusCode = 404;
            
            $user = $this->repository->getUser($userId);
            
            if ($user) {
                $this->repository->deleteUser($userId);
                
                $response = ['message' => 'User deleted'];
                $statusCode = 200;
            }
            
            return response()->json($response, $statusCode);
        }catch(\Exception $e){

        }
    }
}
