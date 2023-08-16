<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\User\Sign\In\Control as SignInControl;
use App\Components\User\Sign\In\FormFactory;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;


final class SignPresenter extends Presenter
{
	public function __construct(
		private FormFactory $userSignInFormFactory
	) {
	}

	private string $storeRequestId = '';

	public function actionIn(string $storeReqId = '')
	{
		$this->storeRequestId = $storeReqId;
	}

	public function actionOut(): void
	{
		$this->user->logout(true);
		$this->flashMessage('Logout Successfull', 'success');
		$this->redirect('Homepage:');
	}

	public function createComponentSignInForm(): Control
	{
		return new SignInControl($this->userSignInFormFactory, [$this, 'onSignInFormSuccess']);
	}

	public function onSignInFormSuccess()
	{
		$this->flashMessage('Login Successfull', 'success');
		$this->redirect('Homepage:');
	}
}