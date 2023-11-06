<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Components;
use App\FrontModule\Presenters\BasePresenter;

final class HomepagePresenter extends BasePresenter
{
	use Components\Post\Grid\PresenterTrait;
}