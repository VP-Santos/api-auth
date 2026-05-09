<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    DeleteUserAction,
    GetAllUsersAction,
    UpdateUserAction
};
use App\Exceptions\BodyNotFoundException;

class AdminUserService extends BaseService
{
    public function __construct(
        protected GetAllUsersAction $getAllUsersAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
    ) {}

    public function updateUser(int $id, array $data)
    {
        $this->targetUserAction($id);

        if (empty($data)) {
            throw new BodyNotFoundException();
        }

        return $this->updateUserAction->execute($id, $data);
    }

    public function deleteUser(int $id)
    {
        $this->targetUserAction($id);

        return $this->deleteUserAction->execute($id);
    }

    public function getAllUsers()
    {
        return $this->getAllUsersAction->execute();
    }
    public function getUser(int $id)
    {
        return $this->userRepository->findOrFail($id);
    }
}
