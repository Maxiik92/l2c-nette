<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\Resource;
use Nette\Application\UI\Presenter as UIPresenter;


abstract class Presenter extends UIPresenter
{
	protected function checkPrivilege(string | Resource $resource, string $privilege): void
	{
		if (!$this->getUser()->isAllowed($resource, $privilege)) {
			$this->flashMessage('Unauthorized for this action!', 'error');
			$this->redirect('Sign:in', $this->storeRequest());
		}
	}
}