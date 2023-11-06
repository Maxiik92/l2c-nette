<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

trait SecurePresenterTrait
{
	protected function startup(): void
	{
		if (!$this->isLinkCurrent('Sign:in') && !$this->user->isAllowed('admin', 'view')) {
			$this->flashMessage('You are unauthorized for this section', 'error');
			$this->redirect('Sign:in');
		}
		parent::startup();
	}
}