<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;
use App\Components;

class SignPresenter extends BasePresenter
{
    use Components\User\Sign\In\PresenterTrait;
}