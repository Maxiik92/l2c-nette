<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

trait PresenterTrait
{
	private ControlFactory $postGridControlFactory;
	private ?int $authorId = null;

	public function injectPostGridControlFactory(ControlFactory $controlFactory)
	{
		$this->postGridControlFactory = $controlFactory;
	}

	public function createComponentPostGrid(): Control
	{
		if (!$this->postGridControlFactory) {
			$this->error("Page not found", 404);
		}

		return $this->postGridControlFactory->create($this->authorId);
	}


}