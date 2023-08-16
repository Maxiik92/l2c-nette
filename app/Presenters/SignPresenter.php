<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\User\Sign\In\ControlFactory;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;


final class SignPresenter extends Presenter
{
	private ControlFactory $userSignInControlFactory;

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
		return $this->userSignInControlFactory->create([$this,'onSignInFormSuccess']);
	}

	public function onSignInFormSuccess()
	{
		$this->flashMessage('Login Successfull', 'success');
		$this->redirect('Homepage:');
	}
}