<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid\Item;

use Nette\Database\Table\ActiveRow;

interface ControlFactory
{
    public function create(
        ActiveRow $item,
    ): Control;
}