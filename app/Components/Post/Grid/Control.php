<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

use App\Model\PostModel;
use Nette\Application\UI\Control as NetteControl;

class Control extends NetteControl
{

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