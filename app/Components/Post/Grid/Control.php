<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

use App\Model\PostModel;
use Nette\Application\UI\Control as NetteControl;
use App\Components;


class Control extends NetteControl
{
    use Components\Post\Grid\Item\ControlTrait;

    public function __construct(
		private PostModel $postModel
	) {
	}

    public function render()
    {
        $this->template->posts = $this->postModel->getPublicArticles()->limit(5);
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

}