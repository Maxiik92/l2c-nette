<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid;

trait ControlTrait
{
	private ControlFactory $postCommentGridControlFactory;
	private bool $canCreateCommentGrid = false;

	public function injectPostCommentGridControlFactory(ControlFactory $controlFactory)
	{
		$this->postCommentGridControlFactory = $controlFactory;
	}

	public function createComponentCommentPostGrid(): Control
	{
		if(!$this->canCreateCommentGrid || $this->postId < 1 || !$this->postCommentGridControlFactory){
            $this->error('Page not Found',404);
        }
		return $this->postCommentGridControlFactory->create($this->postId);
	}
}