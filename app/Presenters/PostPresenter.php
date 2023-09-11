<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostModel;
use App\Presenters\BasePresenter;
use App\Components;
use Nette\Database\Table\ActiveRow;

final class PostPresenter extends BasePresenter
{

	use Components\Post\Manipulate\PresenterTrait;
	use Components\Post\Comment\Add\PresenterTrait;
	// use Components\Post\Detail\ControlTrait;
	use Components\Post\Comment\Grid\PresenterTrait;


	private $post;
	private int $postId = 0;
	public function __construct(
		private PostModel $postModel,
	) {
		parent::__construct();
	}

	public function actionAdd(): void
	{
		$this->checkPriviLege('add');
		$this->canCreatePostForm = true;
	}

	public function actionEdit(int $postId): void
	{
		$this->checkPrivilege('edit');
		$this->entity = $this->checkPostExistence($postId)->toArray();
		$this->canCreatePostForm = true;
	}
	//POTREBNE ROZDELOVAT ACTION A RENDER LEBO RENDER JE LAZY redirecty v actione
	public function actionShow(int $postId): void
	{
		$this->checkPrivilege('view');

		bdump($this->user->isAllowed('post','edit'));
		$this->postId = $postId;
		$this->post = $this->checkPostExistence($postId);
		$this->canCreateCommentForm = $this->getUser()->isAllowed('comment','add');
		$this->canCreateCommentGrid = $this->getUser()->isAllowed('commentGrid','view');
	}
	
	public function renderShow(): void
	{
		$this->template->post = $this->post;
	}

	public function checkPrivilege(string $privilege): void
	{
		if (!$this->getUser()->isAllowed('post', $privilege)) {
			$this->flashMessage('Unauthorized for this action!', 'error');
			$this->redirect('Sign:in', $this->storeRequest());
		}
	}

	private function checkPostExistence(int $postId): ActiveRow
	{
		$post = $this->postModel->getById($postId);
		if (!$post) {
			$this->error('Post not found', 404);
		}
		return $post;
	}
}