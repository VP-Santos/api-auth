<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\GetUserAction;
use App\Domains\Admin\Actions\BanUserAction;
use App\Domains\Admin\Actions\DemoteUserAction;
use App\Domains\Admin\Actions\GetAllUsersAction;
use App\Domains\Admin\Actions\PromoteUserAction;
use App\Domains\Admin\Actions\UnBanUserAction;
use App\Domains\Admin\Exceptions\UserNotFoundException;
use App\Domains\Users\Actions\DeleteUserAction;
use App\Domains\Users\Actions\UpdateUserAction;

class AdminUserService
{
    public function __construct(
        protected GetUserAction $getUser,
        protected GetAllUsersAction $getAllUsers,
        protected UpdateUserAction $updateUser,
        protected DeleteUserAction $deleteUser,
        protected BanUserAction $banUser,
        protected UnBanUserAction $unBanUserAction,
        protected PromoteUserAction $promoteUser,
        protected DemoteUserAction $demoteUserAction,
    ) {}

    /**
     * Método central para pegar o usuário ou lançar exception
     */
    protected function findUserOrFail(int $id)
    {
        $user = $this->getUser->execute($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
    
    public function updateUser(int $id, array $data)
    {
        $user = $this->findUserOrFail($id);
        return $this->updateUser->execute($user, $data);
    }

    public function deleteUser(int $id)
    {
        $user = $this->findUserOrFail($id);
        return $this->deleteUser->execute($user);
    }

    public function getAllUsers()
    {
        return $this->getAllUsers->execute();
    }
    public function getUser(int $id)
    {
        return $this->findUserOrFail($id);
    }
}
