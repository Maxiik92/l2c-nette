<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components;
use Nette\Application\UI\Presenter;


abstract class SignPresenter extends Presenter
{
	use Components\User\Sign\In\PresenterTrait;
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
}