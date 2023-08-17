<?php

declare(strict_types=1);

namespace App\Components\Post\Grid\Item;

trait ControlTrait
{
	private ControlFactory $postGridItemControlFactory;

	public function injectPostGridItemControlFactory(ControlFactory $controlFactory)
	{
		$this->postGridItemControlFactory = $controlFactory;
	}

	public function createComponentPostGrid(): Control
	{
		return $this->postGridItemControlFactory->create();
	}
}