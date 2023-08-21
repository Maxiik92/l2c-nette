<?php

declare(strict_types=1);

namespace App\Components\Post\Manipulate;
use App\Model\PostModel;
use Nette\Application\UI\Form;
use Nette\SmartObject;

class FormFactory {

	use SmartObject;

	private ?int $id;

    public function __construct(
		private PostModel $postModel,
	){}

    public function create(int $id = null): Form{
		$form = new Form;

		$this->id = $id;
		
		$form->addHidden('id');
		$form->addText('title', 'Title:')
			->setRequired();

		$form->addTextArea('content', 'Comment:')
			->setRequired();

		$form->addSubmit('send', 'Publish Post');
		$form->onSuccess[] = [$this, 'onSuccess'];
		
		if($id){
			$form->setDefaults($this->postModel->getById($id));
		}

		return $form;
    }

	public function onSuccess(Form $form, array $data): void
	{
		if($this->id){
			$this->postModel->update((string) $this->id,$data);
		}else{
			unset($data['id']);
			$this->id = $this->postModel->insert($data)->id;
		}
		$form['id']->setValue($this->id);
	}
}