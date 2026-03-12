<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\GetUserAction;
use App\Domains\Admin\Actions\BanUserAction;
use App\Domains\Admin\Actions\GetAllUsersAction;
use App\Domains\Admin\Actions\PromoteUserAction;
use App\Domains\Admin\Exceptions\UserNotFoundException;
use App\Domains\Auth\Actions\DeleteUserAction;
use App\Domains\Auth\Actions\UpdateUserAction;

class AdminUserService
{
    public function __construct(
        protected GetUserAction $getUser,
        protected GetAllUsersAction $getAllUsers,
        protected UpdateUserAction $updateUser,
        protected DeleteUserAction $deleteUser,
        protected BanUserAction $banUser,
        protected PromoteUserAction $promoteUser,
    ) {}

    /**
     * Método central para pegar o usuário ou lançar exception
     */
    protected function findUserOrFail(int $id)
    {
        $user = $this->getUser->execute($id);

        if (!$user) {
            throw new UserNotFoundException();
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

    public function banUser(int $id)
    {
        $user = $this->findUserOrFail($id);
        return $this->banUser->execute($user);
    }

    public function promoteUser(int $id, string $role)
    {
        $user = $this->findUserOrFail($id);
        return $this->promoteUser->execute($user, $role);
    }

    public function getAllUsers()
    {
        return $this->getAllUsers->execute();
    }
    public function getUser($id)
    {
        return $this->findUserOrFail($id);
    }
}
