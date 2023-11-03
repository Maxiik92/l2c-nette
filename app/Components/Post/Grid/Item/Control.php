<?php

declare(strict_types=1);

namespace App\Components\Post\Grid\Item;

use App\Model\Entity\PostResource;
use Nette\Application\UI\Control as NetteControl;

class Control extends NetteControl
{

    public function __construct(
        private PostResource $item
	) {
	}

    public function render()
    {
        $this->template->post = $this->item;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

}