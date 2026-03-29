<?php

namespace App\Domains\Admin\Actions;

use App\Models\User;
use App\Repositories\UserRepository;

class GetUserAction
{
            public function __construct(
        protected UserRepository $repository
    ) {}
    public function execute(int $id): ?User
    {
        return $this->repository->find($id);
    }
}