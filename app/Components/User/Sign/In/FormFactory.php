<?php

declare(strict_types=1);

namespace App\Components\User\Sign\In;
use Exception;
use Nette\Application\UI\Form;
use Nette\Security\User;
use stdClass;

class FormFactory {

    public function __construct(
		private User $user
	){}

    public function create(): Form{
        $form = new Form;
		$form->addEmail('email', 'E-mail:')
			->setRequired('Please enter your E-mail.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addSubmit('send', 'Sign in');

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = [$this, 'onSuccess'];
		return $form;
    }

    public function onSuccess(Form $form, stdClass $data): void
	{
        bdump($data);
		try {
			$this->user->login($data->email, $data->password);
		} catch (Exception $e) {
			$form->addError('Incorrect username or password.');
		}
	}
}