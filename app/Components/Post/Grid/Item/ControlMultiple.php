<?php

declare(strict_types=1);

namespace App\Components\Post\Grid\Item;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

trait ControlMultipleTrait
{
	private ControlFactory $postGridItemControlFactory;
    private Selection $posts;

	public function injectPostGridItemControlFactory(ControlFactory $controlFactory)
	{
		$this->postGridItemControlFactory = $controlFactory;
	}

	public function createComponentPostGridItemMultiple()
    {
        $posts = $this->posts;
        $factory =$this->postGridItemControlFactory;
        return new Multiplier(function (string $id) use ($posts, $factory) {
            return $factory->create($this->posts[(int) $id]);
        });
    }
}