<?php

declare(strict_types=1);

namespace App\Components\Post\Grid\Item;

use App\Model\Entity\PostResource;

interface ControlFactory
{
    public function create(
        PostResource $item,
    ): Control;
}