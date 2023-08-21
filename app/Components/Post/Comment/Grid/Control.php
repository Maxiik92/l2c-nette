<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid;

use App\Components;
use App\Model\CommentModel;
use Exception;
use Nette\Application\UI\Control as NetteControl;
use App\Components\Post\Comment\Grid\Item\ControlFactory;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\Selection;

class Control extends NetteControl
{
    private Selection $comments;

    public function __construct(
        private CommentModel $commentModel,
        //factory musi mat rovnaky nazova ako v traite
        private ControlFactory $controlFactory,
        private int $postId
    ) {
        $this->comments = $this->commentModel->getCommentsByPostId($this->postId);
    }

    public function render()
    {
        $this->template->comments = $this->comments;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentPostCommentGridItemMultiple()
    {
        $items = $this->comments;
        $factory = $this->controlFactory;

        return new Multiplier(function (string $id) use ($items, $factory) {
            return $factory->create($items[(int) $id]);
        });
    }
}