<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid;

interface ControlFactory
{
    public function create(int $postId): Control;
}