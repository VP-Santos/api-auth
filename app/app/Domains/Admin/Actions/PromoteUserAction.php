<?php

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Enums\UserAccessLevel;
use App\Models\User;
use App\Repositories\UserRepository;

class PromoteUserAction
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(User $user)
    {
        $data = ['access_level' => UserAccessLevel::ADMIN->value];

        return $this->repository->update($user, $data);
    }
}
