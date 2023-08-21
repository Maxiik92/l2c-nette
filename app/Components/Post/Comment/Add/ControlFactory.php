<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Add;

interface ControlFactory
{
    public function create(
        callable $onSuccess,
        ?int $id
    ): Control;
}