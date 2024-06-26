<?php

declare(strict_types=1);

namespace App\UI\Home;

use app\Service\LoginAttemptRepository;
use app\Service\UserRepository;
use app\UI\Components\Forms\User\UserForm;
use app\UI\Components\Forms\User\UserFormFactory;
use Nette;

class HomePresenter extends Nette\Application\UI\Presenter
{
    private UserRepository $userRepository;

    private UserFormFactory $userFormFactory;

    private LoginAttemptRepository $loginAttemptRepository;

    public function __construct(
        UserRepository $userRepository,
        UserFormFactory $userFormFactory,
        LoginAttemptRepository $loginAttemptRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userFormFactory = $userFormFactory;
        $this->loginAttemptRepository = $loginAttemptRepository;
    }

    public function renderDefault(): void
    {
        $this->template->users = $this->userRepository->findAll();
        $this->template->loginAttempts = $this->loginAttemptRepository->countLoginAttemptsByUsers($this->template->users);
    }

    public function createComponentUserForm(): UserForm
    {
        return $this->userFormFactory->create();
    }

    public function renderCreate(): void
    {

    }
}
