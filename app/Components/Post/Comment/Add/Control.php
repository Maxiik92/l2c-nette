<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Add;

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
        callable $onSuccess,
        private ?int $id = null,
    ) {
        $this->onSuccess = $onSuccess;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentCommentForm(): Form
    {
        $form = $this->formFactory->create($this->id);
        $form->onSuccess[] = $this->onSuccess;
        return $form;
    }
}