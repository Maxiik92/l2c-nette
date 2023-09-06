<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{

    protected function startup(){
        if (!$this->isLinkCurrent('Sign:in') && !$this->user->isAllowed('admin')){
            $this->flashMessage('You are unauthorized for this section','error');
            $this->redirect('Sign:in');
        }
        parent::startup();
    }
}