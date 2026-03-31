<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    BanUserAction,
    DeleteUserAction,
    DemoteUserAction,
    GetAllUsersAction,
    GetUserAction,
    PromoteUserAction,
    UnBanUserAction,
    UpdateUserAction
};
use App\Exceptions\BodyNotFoundException;
use App\Repositories\UserRepository;

class AdminUserService
{
    public function __construct(
        protected UserRepository $repository,
        protected GetUserAction $getUser,
        protected GetAllUsersAction $getAllUsers,
        protected UpdateUserAction $updateUser,
        protected DeleteUserAction $deleteUser,
        protected BanUserAction $banUser,
        protected UnBanUserAction $unBanUserAction,
        protected PromoteUserAction $promoteUser,
        protected DemoteUserAction $demoteUserAction,
        protected PreventSelfActionService $selfAction,
    ) {}


    /** */
    public function updateUser(int $id, array $data)
    {   

        if(empty($data)){
            throw new BodyNotFoundException();
        }
        
        $this->selfAction->check(request()->user(), $id);

        return $this->updateUser->execute($id, $data);
    }

    public function deleteUser(int $id)
    {
        $this->selfAction->check(request()->user(), $id);

        return $this->deleteUser->execute($id);
    }

    public function getAllUsers()
    {
        return $this->getAllUsers->execute();
    }
    public function getUser(int $id)
    {
        return $this->repository->find($id);
    }
}
