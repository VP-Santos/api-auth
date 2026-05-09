<?php

namespace App\Domains\Admin\Services;


use App\Domains\Admin\Actions\{
    DemoteUserAction,
    PromoteUserAction
};
use App\Repositories\UserRepository;

class PrometeUserService extends BanUserService
{

    public function __construct(
        protected UserRepository $userRepository,
        protected PromoteUserAction $promoteUserAction,
        protected DemoteUserAction $demoteUserAction,
    ) {}

    public function promote(int $id)
    {
        $this->targetUserAction($id);

        return $this->promoteUserAction->execute($id);
    }
    public function demote(int $id)
    {
        $this->targetUserAction($id);

        return $this->demoteUserAction->execute($id);
    }
}
