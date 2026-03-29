<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    BanUserAction,
    UnBanUserAction
};

class BanUserService
{
    public function __construct(

        protected BanUserAction $banUser,
        protected UnBanUserAction $unBanUserAction,
    ) {}

    public function banUser(int $id)
    {
        return $this->banUser->execute($id);
    }
    public function unBanUser(int $id)
    {
        return $this->unBanUserAction->execute($id);
    }
}
