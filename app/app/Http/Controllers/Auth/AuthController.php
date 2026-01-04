<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Users\FormLoginRequest;
use App\Http\Requests\Users\FormStoreUsers;
use App\Http\Requests\Users\FormUpdateUser;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function register(FormStoreUsers $request)
    {
        $userData = $request->validated();

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        $abilities = [$user->access_level];

        $token = $user->createToken('access', $abilities)->plainTextToken;


        $user->current_token = $token;
        $user->save();

        return response()->json([
            'token'  => $token,
            'credenciais' => $user
        ], 200);
    }

    public function login(FormLoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || ! Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'error' => ['As credenciais fornecidas estão incorretas.']
            ]);
        }

        $abilities = [$user->access_level];

        $token = $user->createToken('access', $abilities)->plainTextToken;

        $user->current_token = $token;
        $user->save();

        return response()->json([
            'token' => $token
        ]);
    }

    public function show(Request $request)
    {

        $user = $request->user();

        if (!$user) {

            return response()->json(['message' => 'Não autenticado'], 401);
        }

        return response()->json([
            'token'  => $user['current_token'],
            'credenciais' => $user
        ], 200);
    }
    public function update(FormUpdateUser $request)
    {
        $userData = $request->validated();

        $user = $request->user();

        $user->update($userData);

        return [
            'user' => $user
        ];
    }
    public function logout(Request $request)
    {   
        //exce~]ao para query exception e caso o usuario não esteja logado
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json(['info' => 'usuario deslogado'], 200);
    }
}
