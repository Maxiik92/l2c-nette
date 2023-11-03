<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Presenters\PostPresenter as FrontPostPresenter;

class PostPresenter extends FrontPostPresenter
{
	use SecurePresenterTrait;

	public function actionShow(int $postId): void
	{
		parent::actionShow($postId);
		if($this->post->author_id !== $this->user->id){
			$this->flashMessage('You are unauthorized for this section','error');
            $this->redirect('Sign:in');
		}
	}
}