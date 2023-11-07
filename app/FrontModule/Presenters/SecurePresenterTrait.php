<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;
use App\Model\API\Joke;
use Nette\DI\Attributes\Inject;

trait SecurePresenterTrait
{

	#[Inject] public Joke  $joke;

	protected function startup(): void
	{
		if (!$this->isLinkCurrent('Sign:in') && !$this->user->isAllowed('front', 'view')) {
			$this->flashMessage('You are unauthorized for this section', 'error');
			$this->redirect('Sign:in');
		}
		parent::startup();
	}

	protected function beforeRender():void {
		$this->template->joke = $this->joke->getJoke($this->lang);
	}
}