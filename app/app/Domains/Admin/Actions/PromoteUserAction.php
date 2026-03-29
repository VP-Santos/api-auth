<?php

namespace App\Domains\Admin\Actions;

use App\Repositories\UserRepository;

class PromoteUserAction
{

    const ROLE_ADMIN = 'admin';


    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(int $id)
    {
        $data = ['access_level' => self::ROLE_ADMIN];

        $user = $this->repository->update($id, $data);

        return $user;
    }
}
