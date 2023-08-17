<?php

declare(strict_types=1);

namespace App\Components\Post\Manipulate;

use Nette\Application\UI\Control as NetteControl;
use Nette\Application\UI\Form;

class Control extends NetteControl
{

    /**
     * @var callable
     */
    private $onSuccess;

    public function __construct(
        private FormFactory $formFactory,
        callable $onSuccess
    ) {
        $this->onSuccess = $onSuccess;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentForm(): Form
    {
        $form = $this->formFactory->create();
        $form->onSuccess[] = [$this, 'onSignInFormSuccess'];
        return $form;
    }
}