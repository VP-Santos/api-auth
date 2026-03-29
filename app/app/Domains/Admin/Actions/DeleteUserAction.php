<?php

namespace App\Domains\Admin\Actions;

use App\Repositories\UserRepository;

class DeleteUserAction
{
    public function __construct(
        protected UserRepository $repository,
    ) {}
    public function execute(int $id)
    {
        $user = $this->repository->delete($id);
        
        return $user;
    }
}
