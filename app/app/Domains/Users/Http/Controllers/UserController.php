<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Users\Http\Requests\FormUpdateUser;
use App\Domains\Users\Actions\{
    DeleteMeAction,
    ShowMeAction,
    UpdateMeAction
};
use App\Domains\Users\Http\Requests\FormUpdatePasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        public ShowMeAction $showMeAction,
        public UpdateMeAction $updateMeAction,
        public DeleteMeAction $deleteMeAction,
    ) {}
    public function me(Request $request)
    {
        $user = $request->user();

        $response = $this->showMeAction->execute($user);

        return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => $response
        ], 200);
    }

    public function updateMe(FormUpdateUser $request)
    {
        $user = $request->user();
        $updatedUser = $this->updateMeAction->execute($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User data updated successfully.',
            'data' => $updatedUser
        ], 200);
    }

    public function updatePassword(FormUpdatePasswordRequest $request)
    {
        $user = $request->user();

        $this->updateMeAction->execute($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.'
        ], 200);
    }

    public function deleteMe(Request $request)
    {
        $user = $request->user();

        $this->deleteMeAction->execute($user);

        return response()->json([
            'success' => true,
            'message' => 'Your account deleted successfully.'
        ], 200);
    }
}
