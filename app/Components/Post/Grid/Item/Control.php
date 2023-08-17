<?php

declare(strict_types=1);

namespace App\Components\Post\Grid\Item;

use Nette\Application\UI\Control as NetteControl;
use Nette\Database\Table\ActiveRow;

class Control extends NetteControl
{

    public function __construct(
        private ActiveRow $item
	) {
	}

    public function render()
    {
        $this->template->post = $this->item;
        $this->template->setFile(__DIR__ . '/default.latte')->render();
    }

}