<?php

namespace App\Domains\Admin\Actions;

use App\Repositories\UserRepository;

class GetAllUsersAction
{   
        public function __construct(
        protected UserRepository $repository
    ) {}
    
    public function execute()
    {
        return $this->repository->all();
    }
}