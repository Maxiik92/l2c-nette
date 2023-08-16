<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\User\Sign\In\FormFactory;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;


final class SignPresenter extends Presenter
{
	private FormFactory $userSignInFormFactory;
	private string $storeRequestId = '';

	public function actionIn(string $storeReqId = '')
	{
		$this->storeRequestId = $storeReqId;
	}

	public function actionOut(): void
	{
		$this->flashMessage('Login Successfull', 'success');
		$this->redirect('Homepage:');
	}

	public function createComponentSignInForm(): Form
	{
		$form = $this->userSignInFormFactory->create();
		$form->onSuccess[] = [$this, 'onSignInFormSuccess'];
		return $form;
	}

	public function onSignInFormSuccess()
	{
		$this->flashMessage('Login Successfull', 'success');
		$this->redirect('Homepage:');
	}
}