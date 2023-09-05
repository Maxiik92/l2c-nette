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
        callable $onSuccess,
        private array $entity,
    ) {
        $this->onSuccess = $onSuccess;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentPostForm(): Form
    {
        $form = $this->formFactory->create($this->entity);
        $form->onSubmit[] = [$this, 'onSubmit'];
        $form->onSuccess[] = $this->onSuccess;
        return $form;
    }

    public function onSubmit()
    {
        $this->redrawControl('form');
    }
}