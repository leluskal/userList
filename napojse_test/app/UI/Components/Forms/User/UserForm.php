<?php

namespace app\UI\Components\Forms\User;

use App\Entity\User;
use app\Service\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class UserForm extends Control
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addEmail('email', 'Email')
            ->setRequired('The email is required');

        $form->addPassword('password', 'Password')
            ->setRequired('The password is required');

        $form->addText('full_name', 'Full Name')
            ->setRequired('The name is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values): void
    {
        if ($values->id === '') {
            $user = new User(
                $values->email,
                password_hash($values->password, PASSWORD_BCRYPT)
            );
            $user->setFullName($values->full_name);

            try {
                $this->userRepository->save($user);
            } catch (UniqueConstraintViolationException $e) {
                $this->getPresenter()->flashMessage('Email already exists.', 'danger');
                $this->getPresenter()->redirect('this');
            }

            $this->getPresenter()->flashMessage('The new user has been saved', 'success');
            $this->getPresenter()->redirect('Home:default');
        }
    }

    public function render(): void
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/userForm.latte');
        $template->render();
    }
}