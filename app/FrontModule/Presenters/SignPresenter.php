<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Presenters\SecurePresenterTrait;
use App\Presenters\SignPresenter as APSignPresenter;


final class SignPresenter extends APSignPresenter
{
	use SecurePresenterTrait;
}