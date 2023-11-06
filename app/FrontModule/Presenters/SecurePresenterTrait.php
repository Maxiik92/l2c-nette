<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

trait SecurePresenterTrait
{
	protected function startup(){
        if (!$this->isLinkCurrent('Sign:in') && !$this->user->isAllowed('front','view')){
            $this->flashMessage('You are unauthorized for this section','error');
            $this->redirect('Sign:in');
        }
        parent::startup();
    }
}