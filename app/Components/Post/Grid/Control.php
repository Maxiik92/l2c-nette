<?php

declare(strict_types=1);

namespace App\Components\Post\Grid;

use App\Model\PostModel;
use Nette\Application\UI\Control as NetteControl;
use App\Components\Post\Grid\Item\ControlFactory;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\Selection;

class Control extends NetteControl
{
    private Selection $posts;

    public function __construct(
        private PostModel $postModel,
        private ControlFactory $controlFactory,
    ) {
        $this->posts = $this->postModel->getPublicArticles()->limit(5);
    }

    public function render()
    {
        $this->template->posts = $this->posts;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentPostGridItemMultiple()
    {
        $posts = $this->posts;
        $factory = $this->controlFactory;
        return new Multiplier(function (string $id) use ($posts, $factory) {
            return $factory->create($this->posts[(int) $id]);
        });
    }
}