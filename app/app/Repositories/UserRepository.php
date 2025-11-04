<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserRepository extends AbstractRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Autentica o usuário por email e senha.
     */
    public function authenticate(array $credentials): User
    {
        if (!Auth::attempt($credentials)) {
            throw new Exception('Email e/ou senha inválidos!');
        }

        return Auth::user();
    }

    /**
     * Gera token Sanctum.
     */
    public function generateToken(User $user): string
    {
        // remove tokens anteriores
        $user->tokens()->delete();
        return $user->createToken('user-token')->plainTextToken;
    }

    /**
     * Faz logout apenas do token atual.
     */
    public function logout(User $user): void
    {
        $token = $user->tokens();
        if ($token) {
            $token->delete();
        }
    }
    /**
     * Faz logout de todos os dispositivos (global).
     */
    public function logoutAll(User $user): void
    {
        $user->tokens()->delete();
    }

    public function update(){
        
    }
}
