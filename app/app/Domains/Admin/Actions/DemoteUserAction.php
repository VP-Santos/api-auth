<?php

namespace App\Domains\Admin\Actions;

use App\Repositories\UserRepository;

class DemoteUserAction
{
    const ROLE_BASIC = 'basic';

    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(int $id)
    {
        $data = ['access_level' => self::ROLE_BASIC];

        $user = $this->repository->update($id, $data);

        return $user;
    }
}
