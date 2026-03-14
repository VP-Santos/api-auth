<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Auth\Requests\FormUpdateUser;
use App\Domains\Users\Http\Requests\FormUpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request)
    {
        $user = request()->user();

        return response()->json([
            'credenciais' =>  $user->only([
                'id',
                'name',
                'email',
            ])
        ]);
    }

    public function update(FormUpdateUser $request)
    {
        // $this->authService->updateUser($request->validated(), $request->user());

        return response()->json(
            [
                'success' => true,
                'message' => 'Data updated successfully.'
            ],
            200
        );
    }

    public function updatePassword(FormUpdatePasswordRequest $request)
    {
        $user = $request->user();

        // $this->authService->updatePassword($request->validated(), $user);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function deleteMe(Request $request)
    {
        $user = $request->user();

        $user->delete();

        return response()->json([
            'message' => 'User deleted'
        ]);
    }
}
