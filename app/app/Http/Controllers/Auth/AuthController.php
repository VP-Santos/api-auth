<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends AbstractAuthController
{
    private $userRepository;
    private $user;

    public function __construct()
    {
        $this->userRepository = new UserRepository(new \App\Models\User);
        $this->user = Auth::user();
    }

    public function storeRequest($userData): object
    {
        $userData['password'] = bcrypt($userData['password']);
        $user = $this->userRepository->create($userData);
        $token = $this->userRepository->generateToken($user);

        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'token' => $token,
            'user_info' => [
                'id_register' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_name' => $user->user_name,
                'is_adm' => $user->adm,
                'created_at' => $user->created_at->format('d/m/Y H:i:s')
            ]
        ]);
    }

    public function loginRequest($userData): object
    {
        $user = $this->userRepository->authenticate($userData);
        $token = $this->userRepository->generateToken($user);

        return response()->json([
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'user_info' => [
                'id_register' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_name' => $user->user_name,
                'is_adm' => $user->adm,
                'created_at' => $user->created_at->format('d/m/Y H:i:s')
            ]
        ]);
    }
    public function showRequest():object
    {
        $user = $this->user;
        return response()->json([
            'id_register' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'user_name' => $user->user_name,
            'is_adm' => $user->adm,
            'created_at' => $user->created_at->format('d/m/Y H:i:s')
        ]);
    }

    public function logoutRequest(): object
    {
        $user = $this->user;

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não autenticado ou token inválido.'
            ], 401);
        }

        $this->userRepository->logout($user);

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }

    public function updateRequest() {}
}
