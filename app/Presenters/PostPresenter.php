<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\CommentModel;
use App\Model\PostModel;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use App\Components;

final class PostPresenter extends BasePresenter
{

	use Components\Post\Manipulate\PresenterTrait;
	public function __construct(
		private PostModel $postModel,
		private CommentModel $commentModel
	) {
	}

	public function actionManipulate(int $postId = 0):void {
		if (!$this->getUser()->isLoggedIn()) {
            $this->error('To publish a post you must be logged in!');
            $this->redirect('Sign:in',$this->storeRequest());
        }
		if ($postId == 0) {
			return;
		}

		$post = $this->postModel->getById($postId);
		if(!$post){
			$this->error('Post with selected ID do not exist',404);
		}
		$this->id = $postId;
	}

	public function renderShow(int $postId): void
	{
		$post = $this->postModel->getById($postId);
		if (!$post) {
			$this->error('Post not found');
		}

		$this->template->post = $post;
		$this->template->comments = $post->related('comment')->order('created_at');
	}

	public function renderManipulate(int $postId = 0){
		$this->template->postId = $postId;
	}


	protected function createComponentCommentForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Your name:')
			->setRequired();

		$form->addEmail('email', 'Email:');

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish comment');
		$form->onSuccess[] = [$this, 'commentFormSucceeded'];

		return $form;
	}

	
	public function commentFormSucceeded(\stdClass $data): void
	{
		$this->commentModel->insert([
			'post_id' => $this->getParameter('postId'),
			'name' => $data->name,
			'email' => $data->email,
			'content' => $data->content,
		]);

		$this->flashMessage('Thank you for your comment', 'success');
		$this->redirect('this');
	}
}