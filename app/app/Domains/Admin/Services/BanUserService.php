<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    BanUserAction,
    UnBanUserAction
};
use App\Repositories\UserRepository;

class BanUserService extends UserActionService
{
    public function __construct(
        UserRepository $userRepository,
        protected BanUserAction $banUserAction,
        protected UnBanUserAction $unBanUserAction,

    ) {
        parent::__construct($userRepository);
    }

    public function ban(int $id)
    {
        $user = $this->userRepository->findOrFail($id);

        $this->ensureUserIsNotBanned($user);


        return $this->executeAction(
            $user,
            field: 'is_banned',
            expectedValue: true,
            action: $this->banUserAction,
            message: 'User is already banned.'
        );
    }

    public function unBan(int $id)
    {
        $user = $this->userRepository->findOrFail($id);

        return $this->executeAction(
            $user,
            field: 'is_banned',
            expectedValue: false,
            action: $this->unBanUserAction,
            message: 'User is not banned.'
        );
    }
}
