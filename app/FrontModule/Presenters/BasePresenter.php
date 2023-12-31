<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Presenters\SecurePresenterTrait;
use App\Presenters\Presenter;

abstract class BasePresenter extends Presenter
{
	use SecurePresenterTrait;
}