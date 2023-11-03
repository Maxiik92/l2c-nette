<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid\Item;

use App\Model\CommentModel;
use App\Model\Entity\CommentResource;
use Nette\Application\UI\Control as NetteControl;
use Nette\Security\User;

class Control extends NetteControl
{

    public function __construct(
        private CommentResource $item,
		private \Closure $onDelete,
		private CommentModel $commentModel,
		private User $user,
	) {
	}

    public function render()
    {
        $this->template->comment = $this->item;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

	public function handleDelete():void {
		$isAllowedToDeleteThis = $this->user->isAllowed($this->item, 'delete');
		if ($isAllowedToDeleteThis) {
			$this->commentModel->delete($this->item->id);
		}
		($this->onDelete)($isAllowedToDeleteThis);
	}
	

}