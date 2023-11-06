<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Application\UI\Form;
use Nette\Localization\Translator;

class FormFactory
{

	public function __construct(
		private Translator $translator
	) {
	}
	public function create(): Form
	{
		$form = new Form();
		$form->getElementPrototype()
			->setAttribute('novalidate', 'novalidate')
			->setAttribute('class', 'ajax');
			
		$form->setTranslator($this->translator);

		return $form;
	}
}