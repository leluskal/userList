<?php

namespace app\UI\Components\Forms\User;

use app\Service\UserRepository;

class UserFormFactory
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(): UserForm
    {
        return new UserForm($this->userRepository);
    }
}