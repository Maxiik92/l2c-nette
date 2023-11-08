<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Components;
use App\FrontModule\Presenters\BasePresenter;
use Kdyby\Replicator\Container;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\SubmitButton;

final class HomepagePresenter extends BasePresenter
{
	use Components\Post\Grid\PresenterTrait;

	public function renderTest()
	{

	}
	/**
	 * z dokumentacie na https://github.com/Kdyby/FormsReplicator/blob/master/docs/en/index.md
	 */
	public function createComponentDynamicForm()
	{
		$form = new Form();

		$form->addText("name", "Name:")
			->setRequired("name");

		// $removeCallback = [$this, 'myFormRemoveElementClicked'];

		// $cont = $form->addDynamic('mobiles', static function ($container) use ($removeCallback): void {
		$cont = $form->addDynamic('mobiles', static function ($container): void {
			$container->addText('mobile', 'Mobile:');
			$container->addSubmit('remove', 'Remove')
				->setValidationScope([])
				->addRemoveOnClick();//takisto skratena verzia toho ze nepotrebujeme callback
				// ->onClick[] = $removeCallback;
		});

		$cont->addSubmit('add', 'Add mobile')
			->setValidationScope([])
			// ->onClick[] = [$this, 'myFormAddElementClicked'];
			->addCreateOnClick();//toto je skratene a bez potrebnej metody toho co je hore 

		$form->addSubmit('submit', 'Submit');

		$form->onSuccess[] = [$this, 'onSuccess'];

		return $form;
	}

	// public function myFormRemoveElementClicked(SubmitButton $button): void
	// {
	// 	$mobile = $button->parent->parent;
	// 	$mobile->remove($button->parent, true);
	// }

	// public function myFormAddElementClicked(SubmitButton $button): void
	// {
	// 	$button->parent->createOne();
	// }

	public function onSuccess(Form $form)
	{
		bdump($form->getValues());
	}
}