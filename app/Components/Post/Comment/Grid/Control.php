<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid;

use App\Components;
use App\Model\CommentModel;
use Closure;
use Exception;
use Nette\Application\UI\Control as NetteControl;
use App\Components\Post\Comment\Grid\Item\ControlFactory;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\Selection;
use Nette\Http\Session;

class Control extends NetteControl
{
    private Selection $comments;
    public int $page = 1;
    private int $itemsPerPage = 3;

    public function __construct(
        private CommentModel $commentModel,
        //factory musi mat rovnaky nazova ako v traite
        private ControlFactory $controlFactory,
        private int $postId,
        private Session $session
    ) {
        // unset($_SESSION['commentsPage']);

        if (isset($_SESSION['commentsPage'])) {
            $this->page = $_SESSION['commentsPage'];
        }
        if(isset($_SESSION['CommentsPagePost'.$this->postId])){
            bdump($_SESSION['CommentsPagePost'.$this->postId] < $this->page);
            if($_SESSION['CommentsPagePost'.$this->postId] < $this->page){
                $this->page = 1;
            }
        }
        bdump($this->page);
    }

    public function render()
    {
        $this->template->numOfPages = 0;
        $this->template->page = $this->page;
        $this->comments = $this->commentModel->getCommentsByPostId($this->postId)->page($this->page, $this->itemsPerPage, $this->template->NumOfPages);
        $_SESSION['CommentsPagePost'.$this->postId] = $this->template->NumOfPages;
        $this->template->comments = $this->comments;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentPostCommentGridItemMultiple()
    {
        $model = $this->commentModel;
        $factory = $this->controlFactory;
		$onDeleteCallback = Closure::fromCallable([$this,'onCommentDelete']);

        return new Multiplier(function (string $id) use ($model, $factory,$onDeleteCallback) {
            return $factory->create(
				$model->toEntity($model->getById((int) $id)),
				$onDeleteCallback
			);
        });
    }

    public function handleLoadMore(): void
    {
        $this->page += 1;
        $_SESSION['commentsPage'] = $this->page;
        $this->redrawControl('comments');
    }

	public function onCommentDelete(bool $isAllowed):void {
		if($isAllowed){
			$this->flashMessage('Comment delete successfull','success');
			$this->redrawControl('comments');
		}else{
			$this->flashMessage('You are not allowed to delete this comment','error');
		}
		$this->redrawControl('flashes');
	}
}