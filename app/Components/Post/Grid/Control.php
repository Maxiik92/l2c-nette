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
    /**
     *@var int @persistant
     */
    public int $page = 1;
    private int $itemsPerPage = 5;
    private Selection $posts;

    public function __construct(
        private PostModel $postModel,
        private ControlFactory $controlFactory,
    ) {
    }

    public function render()
    {
        $this->template->numOfPages = 0;
        $this->template->page = $this->page;
        $this->template->posts = $this->postModel->getPublicArticles()->page($this->page, $this->itemsPerPage,$this->template->numOfPages);
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

    public function createComponentPostGridItemMultiple()
    {
        $postModel = $this->postModel;
        $factory = $this->controlFactory;
        return new Multiplier(function (string $id) use ($postModel, $factory) {
            return $factory->create($postModel->toEntity($postModel->getById((int)$id)));
        });
    }

    public function handlePage(int $page): void
    {
        $this->page = $page;
        $this->redrawControl('posts');
    }
}