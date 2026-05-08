<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    DeleteUserAction,
    GetAllUsersAction,
    UpdateUserAction
};
use App\Exceptions\BodyNotFoundException;
use App\Repositories\UserRepository;

class AdminUserService
{
    public function __construct(
        protected UserRepository $repository,
        protected GetAllUsersAction $getAllUsersAction,
        protected UpdateUserAction $updateUserAction,
        protected DeleteUserAction $deleteUserAction,
        protected PreventSelfActionService $selfAction,
    ) {}

    public function updateUser(int $id, array $data)
    {   

        if(empty($data)){
            throw new BodyNotFoundException();
        }
        
        $this->selfAction->check(request()->user(), $id);

        return $this->updateUserAction->execute($id, $data);
    }

    public function deleteUser(int $id)
    {
        $this->selfAction->check(request()->user(), $id);

        return $this->deleteUserAction->execute($id);
    }

    public function getAllUsers()
    {
        return $this->getAllUsersAction->execute();
    }
    public function getUser(int $id)
    {
        return $this->repository->find($id);
    }
}
