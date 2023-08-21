<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Add;

use Nette\Application\UI\Form;

//TRAITA sluzi na implementaciu kodu ktory je pre presenter specificky
trait PresenterTrait
{
    private ControlFactory $postCommentControlFactory;
    private int $postId = 0;
    private bool $canCreateCommentForm = false;

    public function injectPostCommentControlFactory(ControlFactory $controlFactory)
    {
        $this->postCommentControlFactory = $controlFactory;
    }

    public function createComponentCommentForm(): Control
    {
        if(!$this->canCreateCommentForm ||$this->postId < 1 || !$this->postCommentControlFactory){
            $this->error("Page not found",404);
        }

        return $this->postCommentControlFactory->create(
            [$this, 'onCommentSuccess'],
            $this->postId
        );
    }

    public function onCommentSuccess(Form $form, array $values)
    {
        $this->flashMessage('Thanks for your comment', 'success');
        $this->redirect('this');
    }

}