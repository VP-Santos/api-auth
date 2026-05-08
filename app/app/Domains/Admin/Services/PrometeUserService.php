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
        protected PromoteUserAction $promoteUserAction,
        protected DemoteUserAction $demoteUserAction,
    ) {}

    public function promote(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        return $this->promoteUserAction->execute($id);
    }
    public function demote(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        return $this->demoteUserAction->execute($id);
    }
}
