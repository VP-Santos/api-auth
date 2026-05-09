<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    PromoteUserAction,
    DemoteUserAction
};
use App\Repositories\UserRepository;

class RoleUserService extends UserActionService
{
    public function __construct(
        UserRepository $userRepository,
        protected PromoteUserAction $promoteUserAction,
        protected DemoteUserAction $demoteUserAction,
    ) {
        parent::__construct($userRepository);
    }

    public function promote(int $id)
    {
        $user = $this->userRepository->findOrFail($id);

        $this->ensureUserIsNotBanned($user);

        return $this->executeAction(
            $user,
            field: 'access_level',
            expectedValue: 'admin',
            action: $this->promoteUserAction,
            message: 'User is already an admin.'
        );
    }

    public function demote(int $id)
    {
        $user = $this->userRepository->findOrFail($id);

        $this->ensureUserIsNotBanned($user);

        return $this->executeAction(
            $user,
            field: 'access_level',
            expectedValue: 'basic',
            action: $this->demoteUserAction,
            message: 'User is already basic.'
        );
    }
}
