<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    BanUserAction,
    UnBanUserAction
};

class BanUserService
{
    public function __construct(
        protected PreventSelfActionService $selfAction,
        protected BanUserAction $banUser,
        protected UnBanUserAction $unBanUserAction,
    ) {}

    public function ban(int $id)
    {
        $this->selfAction->check(request()->user(), $id);

        return $this->banUser->execute($id);
    }
    public function unBan(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        
        return $this->unBanUserAction->execute($id);
    }
}
