<?php

namespace App\Domains\Admin\Actions;

use App\Repositories\UserRepository;

class UnBanUserAction
{
    public function __construct(
        protected UserRepository $repository
    ) {}

    public function execute(int $id)
    {
        $data = [
            'is_banned' => false
        ];

        $user = $this->repository->update($id, $data);

        return $user;
    }
}
