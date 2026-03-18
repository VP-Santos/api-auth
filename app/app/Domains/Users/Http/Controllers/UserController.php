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
            'message' => 'User retrieved successfully.',
            'data' => $response
        ], 200);
    }

    public function updateMe(FormUpdateUser $request)
    {
        $user = $request->user();
        $updatedUser = $this->updateUserAction->execute($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User data updated successfully.',
            'data' => $updatedUser
        ], 200);
    }

    public function updatePassword(FormUpdatePasswordRequest $request)
    {
        $user = $request->user();

        $this->updateUserAction->execute($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ], 200);
    }

    public function deleteMe(Request $request)
    {
        $user = $request->user();

        $this->deleteUserAction->execute($user);

        return response()->json([
            'success' => true,
            'message' => 'Your account deleted successfully.'
        ], 200);
    }
}
