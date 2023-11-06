<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\CustomTranslator;
use App\Model\Entity\Resource;
use Nette\Application\Attributes\Persistent;
use Nette\Application\UI\Presenter as UIPresenter;
use Nette\DI\Attributes\Inject;
use Nette\Localization\Translator;
use Latte\Essential\TranslatorExtension;
use Latte\Engine;


abstract class Presenter extends UIPresenter
{

	#[Persistent] public string $lang;
	#[Inject] public Translator $translator;

	protected function startup(): void
	{
		parent::startup();
		$this->setTemplateTranslator();
	}

	protected function checkPrivilege(string|Resource $resource, string $privilege): void
	{
		if (!$this->getUser()->isAllowed($resource, $privilege)) {
			$this->flashMessage('Unauthorized for this action!', 'error');
			$this->redirect('Sign:in', $this->storeRequest());
		}
	}
/**
 * setTemplateTranslator
 * sets Default language of translator based on the path variable
 * thanks to translator extension possibility to use {_'hello_world'} instead of {='hello_world'|translate} in latte files
 */
	public function setTemplateTranslator(){
		if ($this->translator instanceof CustomTranslator) {
			$this->translator->setLang($this->lang);
		}
		$extension = new TranslatorExtension([$this->translator, 'translate']);
		$latte = new Engine;
		$latte->addExtension($extension);
		$this->template->setTranslator($this->translator);
	}
}