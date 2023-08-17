<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\PostModel;
use Nette;
use Nette\Application\UI\Form;


final class EditPresenter extends Nette\Application\UI\Presenter
{
	private Nette\Database\Explorer $database;

	public function __construct(
		private PostModel $postModel
	) {
	}

	public function startup(): void
	{
		parent::startup();

		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect('Sign:in');
		}
	}


	public function renderEdit(int $postId): void
	{
		$post = $this->postModel->getById($postId);

		if (!$post) {
			$this->error('Post not found');
		}

		$this->getComponent('postForm')
			->setDefaults($post->toArray());
	}


	protected function createComponentPostForm(): Form
	{
		$form = new Form;
		$form->addText('title', 'Title:')
			->setRequired();
		$form->addTextArea('content', 'Content:')
			->setRequired();

		$form->addSubmit('send', 'Save and publish');
		$form->onSuccess[] = [$this, 'postFormSucceeded'];

		return $form;
	}


	public function postFormSucceeded(array $data): void
	{
		$postId = $this->getParameter('postId');

		if ($postId) {
			$post = $this->postModel->update($postId, $data);
			$this->flashMessage('Post was updated', 'success');
		} else {
			$post = $this->postModel->insert($data);
			$this->flashMessage('Post was published', 'success');
		}
		$this->redirect('Post:show', $post->id);
	}
}