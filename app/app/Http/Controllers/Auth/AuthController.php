<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Users\FormLoginRequest;
use App\Http\Requests\Users\FormStoreUsers;
use App\Http\Requests\Users\FormUpdateUser;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    private $userRepository;
    private $user;

    // public function __construct()
    // {
    //     $this->userRepository = new UserRepository(new \App\Models\User);
    // }


    public function register(FormStoreUsers $request)
    {
        $userData = $request->validated();

        // 1. Criptografa a senha antes de criar o usuário
        $userData['password'] = bcrypt($userData['password']);

        // 2. Cria o usuário no banco de dados
        $user = User::create($userData);

        // 3. Define as habilidades (abilities) como um array
        $abilities = [$user->access_level];

        // 4. Cria o token usando o Sanctum
        $token = $user->createToken('access', $abilities)->plainTextToken;

        // 5. 🎯 GRAVAÇÃO DO TOKEN ATUAL (AQUI ESTÁ A MUDANÇA)
        $user->current_token = $token;
        $user->save(); // Salva a instância do usuário com o novo token

        return [
            'token'  => $token,
            'credenciais' => $user
        ];
    }

    public function login(FormLoginRequest $request)
    {
        // 1. Encontra o usuário pelo e-mail
        $user = User::where('email', $request->email)->first();

        // 2. Verifica se o usuário existe e se a senha está correta
        if (!$user || ! Hash::check($request->password, $user->password)) {
            // Se a autenticação falhar, lança uma exceção
            // Isso retorna uma resposta 401 ou 422 para o cliente
            throw ValidationException::withMessages([
                'error' => ['As credenciais fornecidas estão incorretas.']
            ]);
        }

        // 3. Define as habilidades (abilities) como um array
        // Usando o access_level do usuário logado
        $abilities = [$user->access_level];

        // 4. Cria o novo token do Sanctum
        // O primeiro argumento é o nome do token ('access' é comum)
        $token = $user->createToken('access', $abilities)->plainTextToken;

        // 5. 🎯 ATUALIZAÇÃO DO current_token
        // Grava o token puro (plaintext) na coluna current_token
        $user->current_token = $token;
        $user->save();

        // 6. Retorna o token na resposta
        return response()->json([
            'token' => $token
        ]);
    }
    public function update(FormUpdateUser $request) {
        $userData = $request->validated();
        
        $user = $request->user();

        $user->update($userData);

        return [
            'user' => $user
        ];
    }
    public function logout(Request $request) {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return ['info' => 'usuario deslogado'];
    }
    public function show(Request $request)
    {
        // 1. O usuário é injetado no objeto Request pelo middleware 'auth:sanctum'.
        $user = $request->user();

        // Verificação de segurança (Embora não estritamente necessária em rotas protegidas)
        if (!$user) {
            // Isso só ocorreria se o middleware falhasse ou não estivesse aplicado
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        // 2. Retorna as informações do usuário
        return response()->json([
            'id'             => $user->id,
            'name'           => $user->name,
            'email'          => $user->email,
            'access_level'   => $user->access_level,
            'current_token'  => $user->current_token,
        ]);
    }
}
