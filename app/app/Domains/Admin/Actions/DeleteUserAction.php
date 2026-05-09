<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;
use App\Repositories\UserRepository;

class DeleteUserAction
{
    public function __construct(
        protected UserRepository $repository,
    ) {}
    public function execute(User $user)
    {
        $user = $this->repository->delete($user);
        
        return $user;
    }
}
