<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

use App\Components;
use App\Model\PostModel;
use Nette\Application\UI\Control as NetteControl;
use App\Components\Post\Grid\Item\ControlFactory;

class Control extends NetteControl
{
    use Components\Post\Grid\Item\ControlMultipleTrait;

    public function __construct(
        private PostModel $postModel,
        //factory musi mat rovnaky nazova ako v traite
        private ControlFactory $postGridItemControlFactory,
    ) {
        $this->posts = $this->postModel->getPublicArticles()->limit(5);
    }

    public function render()
    {
        $this->template->posts = $this->posts;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }
}