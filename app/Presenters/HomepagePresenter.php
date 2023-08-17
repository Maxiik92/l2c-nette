<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components;
use App\Presenters\BasePresenter;

final class HomepagePresenter extends BasePresenter
{
use Components\Post\Grid\ControlTrait;
}