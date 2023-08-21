<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid\Item;
use Nette\Database\Table\ActiveRow;

trait ControlOneTrait
{
	private ControlFactory $postCommentGridItemControlFactory;
	private ActiveRow $postCommentGridItem;

	public function injectPostCommentGridItemControlFactory(ControlFactory $controlFactory)
	{
		$this->postCommentGridItemControlFactory = $controlFactory;
	}

	public function createComponentCommentPostGridItem(): Control
	{
		return $this->postCommentGridItemControlFactory->create($this->postCommentGridItem);
	}
}