<?php

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Repositories\AdminRepository;

class BanUserAction
{
    public function __construct(
        protected AdminRepository $repository
    ) {}

    public function execute(int $id)
    {
        $data = [
            'is_banned' => true
        ];
        $user = $this->repository->update($id, $data);

        return $user;
    }
}
