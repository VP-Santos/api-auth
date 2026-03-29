<?php

namespace App\Domains\Admin\Services;


use App\Domains\Admin\Actions\{
    DemoteUserAction,
    PromoteUserAction
};

class PrometeUserService
{
    public function __construct(
        protected PreventSelfActionService $selfAction,
        protected PromoteUserAction $promoteUser,
        protected DemoteUserAction $demoteUserAction,
    ) {}

    public function promote(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        return $this->promoteUser->execute($id);
    }
    public function demote(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        return $this->promoteUser->execute($id);
    }
}
