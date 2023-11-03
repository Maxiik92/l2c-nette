<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\PostResource;
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


	private PostResource $post;
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
		$post = $this->checkPostExistence($postId);
		$this->checkPrivilege('edit',$this->postModel->toEntity($post));
		$this->entity = $post->toArray();
		$this->canCreatePostForm = true;
	}
	//POTREBNE ROZDELOVAT ACTION A RENDER LEBO RENDER JE LAZY redirecty v actione
	public function actionShow(int $postId): void
	{
		$this->post = $this->postModel->toEntity($this->checkPostExistence($postId));
		$this->checkPrivilege('view');

		$this->postId = $postId;


		$this->canCreateCommentForm = $this->getUser()->isAllowed('comment', 'add');
		$this->canCreateCommentGrid = $this->getUser()->isAllowed('commentGrid', 'view');
	}

	public function renderShow(): void
	{
		$this->template->post = $this->post;
	}

	public function checkPrivilege(string $privilege, string | PostResource $resource = 'post'): void
	{
		if (!$this->getUser()->isAllowed($resource, $privilege)) {
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

	public function handleDelete(): void
	{
		$isAllowedToDeletePost = $this->user->isAllowed($this->post, 'delete');
		if ($isAllowedToDeletePost) {
			$this->postModel->delete($this->post->id);
			$this->flashMessage('Post successfully deleted.', 'success');
			$this->redirect('Homepage:default');
		}
		$this->error('Not Allowed to delete this post', 403);
	}
}