<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Add;

use App\Model\CommentModel;
use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\SmartObject;
use App\Core\FormFactory as FF;


class FormFactory
{
	use SmartObject;
	private int $postId;

	public function __construct(
		private CommentModel $commentModel,
		private FF $formFactory,
		private User $user,
	) {
	}

	public function create(int $id = null): Form
	{
		$this->postId = $id;
		$form = $this->formFactory->create();
		$form->addText('name', 'Your name:')
			->setRequired();

		$form->addEmail('email', 'Email:');

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish comment');
		$form->onSuccess[] = [$this, 'onCommentSuccess'];

		return $form;
	}

	public function onCommentSuccess(Form $form, array $data): void
	{
		$data['post_id'] = $this->postId;
		$data['author_id'] = $this->user->id;
		$this->commentModel->insert($data)->id;
	}
}