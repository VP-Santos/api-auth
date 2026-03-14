<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Auth\Requests\FormUpdateUser;
use App\Domains\Users\Actions\{DeleteUserAction, ShowUserAction, UpdateUserAction};
use App\Domains\Users\Http\Requests\FormUpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        public ShowUserAction $showUserAction,
        public UpdateUserAction $updateUserAction,
        public DeleteUserAction $deleteUserAction,
    ) {}
    public function me(Request $request)
    {
        $user = $request->user();

        $response = $this->showUserAction->execute($user);

        return response()->json([
            'success' => true,
            'credenciais' =>  $response
        ]);
    }

    public function updateMe(FormUpdateUser $request)
    {
        $this->updateUserAction->execute($request->user(), $request->validated());

        return response()->json(
            [
                'success' => true,
                'message' => 'Data updated successfully.'
            ],
        );
    }

    public function updatePassword(FormUpdatePasswordRequest $request)
    {
        $user = $request->user();

        $this->updateUserAction->execute($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ]);
    }

    public function deleteMe(Request $request)
    {
        $user = $request->user();

        $this->deleteUserAction->execute($user);

        return response()->json([
            'message' => 'User deleted'
        ]);
    }
}
