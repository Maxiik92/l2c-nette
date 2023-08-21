<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid;

use App\Components;
use App\Model\CommentModel;
use Nette\Application\UI\Control as NetteControl;
use App\Components\Post\Comment\Grid\Item\ControlFactory;

class Control extends NetteControl
{
    use Components\Post\Comment\Grid\Item\ControlMultipleTrait;

    public function __construct(
        private CommentModel $commentModel,
        //factory musi mat rovnaky nazova ako v traite
        private ControlFactory $postCommentGridItemControlFactory,
        private int $postId
    ) {
        $this->comments = $this->commentModel->getCommentsByPostId($this->postId);
    }

    public function render()
    {
        $this->template->comments = $this->comments;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }
}