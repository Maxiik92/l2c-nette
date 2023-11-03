<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid\Item;

use App\Model\Entity\CommentResource;

interface ControlFactory
{
    public function create(
        CommentResource $item,
		\Closure $onDelete,
    ): Control;
}