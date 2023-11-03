<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;
use App\Components\Post\Grid\PresenterTrait;

class HomepagePresenter extends BasePresenter
{
	use PresenterTrait;

	public function actionDefault(): void {
		$this->authorId = $this->user->id;
	}
}