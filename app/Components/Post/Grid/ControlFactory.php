<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

interface ControlFactory
{
	public function create(
		?int $authorId,
	): Control;
}