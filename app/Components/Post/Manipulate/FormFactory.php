<?php

declare(strict_types=1);

namespace App\Components\Post\Manipulate;

use App\Model\PostModel;
use Nette\Application\UI\Form;
use Nette\SmartObject;

class FormFactory
{

	use SmartObject;

	private array $entity;

	public function __construct(
		private PostModel $postModel,
	) {
	}

	public function create(array $entity = null): Form
	{
		$form = new Form;

		$this->entity = $entity;

		$form->addHidden('id');
		$form->addText('title', 'Title:')
			->setRequired();

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish Post');
		$form->onSuccess[] = [$this, 'onSuccess'];

		$form->setDefaults($entity);

		return $form;
	}

	public function onSuccess(Form $form, array $data): void
	{
		$eId = $this->entity['id'];
		if ($eId) {
			$this->postModel->update($eId, $data);
		} else {
			unset($data['id']);
			$this->entity = $this->postModel->insert($data)->toArray();
			$eId = $this->entity['id'];
		}
		$form['id']->setValue($eId);
	}
}