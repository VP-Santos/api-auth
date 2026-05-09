<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    DeleteUserAction,
    GetAllUsersAction,
    UpdateUserAction
};
use App\Exceptions\BodyNotFoundException;
use App\Repositories\UserRepository;

class AdminUserService extends BaseService
{
    public function __construct(
        UserRepository $userRepository,
        protected GetAllUsersAction $getAllUsersAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
    ) {
        parent::__construct($userRepository);
    }
    public function updateUser(int $id, array $data)
    {
        $user = $this->authorizeUserActionById($id);

        $this->ensureUserIsNotBanned($user);

        if (empty($data)) {
            throw new BodyNotFoundException();
        }

        return $this->updateUserAction->execute($user, $data);
    }

    public function deleteUser(int $id)
    {
        $user = $this->authorizeUserActionById($id);

        return $this->deleteUserAction->execute($user);
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
