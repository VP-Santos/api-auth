<?php

namespace App\Domains\Admin\Services;


use App\Domains\Admin\Actions\{
    DemoteUserAction,
    PromoteUserAction
};

class PrometeUserService
{
    public function __construct(
        protected PromoteUserAction $promoteUser,
        protected DemoteUserAction $demoteUserAction,
    ) {}

    public function promoteUser(int $id)
    {
        return $this->promoteUser->execute($id);
    }
    public function demoteUser(int $id)
    {
        return $this->promoteUser->execute($id);
    }
}
