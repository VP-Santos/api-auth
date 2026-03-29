<?php

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Repositories\AdminRepository;
use App\Models\User;

class DemoteUserAction
{
    const ROLE_BASIC = 'basic';

    public function __construct(
        protected AdminRepository $repository
    ) {}

    public function execute(int $id)
    {
        $data = ['access_level' => self::ROLE_BASIC];

        $user = $this->repository->update($id, $data);

        return $user;
    }
}
