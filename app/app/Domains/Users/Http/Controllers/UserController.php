<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Users\Http\Requests\FormUpdateUser;
use App\Domains\Users\Actions\{
    DeleteMeAction,
    UpdateMeAction
};
use App\Domains\Users\Http\Requests\FormUpdatePasswordRequest;
use App\Domains\Users\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        public UpdateMeAction $updateMeAction,
        public DeleteMeAction $deleteMeAction,
    ) {}
    public function me(Request $request)
    {
        $user = $request->user();

        return $this->success(
            'User retrieved successfully',
            new UserResource($user)
        );
    }

    public function updateMe(FormUpdateUser $request)
    {
        $user = $request->user();

        $updatedUser = $this->updateMeAction->execute(
            $user,
            $request->validated()
        );

        return $this->success(
            'User data updated successfully.',
            new UserResource($updatedUser)
        );
    }

    public function updatePassword(FormUpdatePasswordRequest $request)
    {
        $user = $request->user();

        $this->updateMeAction->execute(
            $user,
            $request->validated()
        );

        return $this->success('Password updated successfully.');
    }

    public function deleteMe(Request $request)
    {
        $user = $request->user();

        $this->deleteMeAction->execute($user);

        return $this->success('Your account deleted successfully.');
    }
}
