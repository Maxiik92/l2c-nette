<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Add;

use App\Model\CommentModel;
use Nette\Application\UI\Form;
use Nette\SmartObject;

class FormFactory
{
	use SmartObject;
	private int $postId;

	public function __construct(
		private CommentModel $commentModel,
	) {
	}

	public function create(int $id = null): Form
	{
		$this->postId = $id;
		$form = new Form;
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
		$this->commentModel->insert($data)->id;
	}
}