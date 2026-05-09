<?php

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Enums\UserAccessLevel;
use App\Models\User;
use App\Repositories\UserRepository;

class DemoteUserAction
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(User $user)
    {
        $data = ['access_level' => UserAccessLevel::BASIC->value];

        return $this->repository->update($user, $data);
    }
}
