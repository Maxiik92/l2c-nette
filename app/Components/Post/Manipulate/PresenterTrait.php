<?php

declare(strict_types=1);

namespace App\Components\Post\Manipulate;

use Nette\Application\UI\Form;

//TRAITA sluzi na implementaciu kodu ktory je pre presenter specificky
trait PresenterTrait
{

    private ControlFactory $postManipulateControlFactory;
    private array $entity = [
        'id'=> 0
    ];

    public function injectPostManipulateControlFactory(ControlFactory $controlFactory)
    {
        $this->postManipulateControlFactory = $controlFactory;
    }

    public function createComponentPostForm(): Control
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->error('To publish a post you must be logged in!');
            // $this->redirect('Sign:in');
        }

        return $this->postManipulateControlFactory->create(
            [$this, 'onSuccess'],
            $this->entity
        );
    }

    public function onSuccess(Form $form, array $values)
    {
        $this->flashMessage('Post successfully published', 'success');
        $this->redirect('show', $values['id']);
    }

}