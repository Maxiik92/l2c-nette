<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components;
use App\Model\PostModel;
use App\Presenters\BasePresenter;
use Nette\Security\User;

final class HomepagePresenter extends BasePresenter
{
	use Components\Post\Grid\PresenterTrait;
}