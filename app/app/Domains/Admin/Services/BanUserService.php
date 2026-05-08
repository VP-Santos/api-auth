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
        protected BanUserAction $banUserAction,
        protected UnBanUserAction $unBanUserAction,
    ) {}


    //TODO criar a logica para verificar se já foi realizado a ação
    public function ban(int $id)
    {
        $this->selfAction->check(request()->user(), $id);

        return $this->banUserAction->execute($id);
    }
    public function unBan(int $id)
    {
        $this->selfAction->check(request()->user(), $id);
        
        return $this->unBanUserAction->execute($id);
    }
}
