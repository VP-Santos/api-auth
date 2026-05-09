<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Actions\{
    BanUserAction,
    UnBanUserAction
};
use App\Repositories\UserRepository;
use Exception;

class BanUserService extends BaseService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected BanUserAction $banUserAction,
        protected UnBanUserAction $unBanUserAction,
    ) {}


    //TODO criar a logica para verificar se já foi realizado a ação
    public function ban(int $id)
    {
        $this->targetUserAction($id);

        $user = $this->userRepository->findOrFail($id);

        if ($user->is_banned == 1) {
            throw new \Exception('This action has already been performed on this user.');
        }
        return $this->banUserAction->execute($id);
    }
    public function unBan(int $id)
    {
        $this->targetUserAction($id);

        $user = $this->userRepository->findOrFail($id);

        if ($user->is_banned != 1) {
            dd('não tem bam');
        }
        return $this->unBanUserAction->execute($id);
    }

}
