<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

trait ControlTrait
{
	private ControlFactory $postGridControlFactory;

	public function injectPostGridControlFactory(ControlFactory $controlFactory)
	{
		$this->postGridControlFactory = $controlFactory;
	}

	public function createComponentPostGrid(): Control
	{
		return $this->postGridControlFactory->create();
	}
}