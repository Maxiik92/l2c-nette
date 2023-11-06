<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Components;
use App\FrontModule\Presenters\BasePresenter;
use App\Model\CustomTranslator;
use App\Model\SettingModel;
use App\Model\TranslateModel;

final class HomepagePresenter extends BasePresenter
{
	use Components\Post\Grid\PresenterTrait;
	// public function __construct(private TranslateModel $model, private CustomTranslator $translator)
	// {
	// 	// bdump($translator, 'translator');
	// 	// bdump($this->translator->translate('hello_world','en'),'translate');
	// }

	public function startup() : void{
		parent::startup();
		bdump($this->translator,'translator');
		bdump($this->translator->translate('hello_world',lang:'sk'),'translate');
	}
}