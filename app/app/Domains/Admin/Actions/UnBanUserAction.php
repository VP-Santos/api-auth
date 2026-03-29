<?php

namespace App\Domains\Admin\Actions;

use App\Domains\Admin\Repositories\AdminRepository;

class UnBanUserAction
{
    public function __construct(
        protected AdminRepository $repository
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
