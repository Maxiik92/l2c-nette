<?php

declare(strict_types=1);

namespace App\Components\Post\Comment\Grid\Item;

use Exception;
use Nette\Application\UI\Multiplier;
use Nette\Database\Table\Selection;

trait ControlMultipleTrait
{
    private ControlFactory $postCommentGridItemControlFactory;
    private Selection $comments;

    public function injectPostCommentGridItemControlFactory(ControlFactory $controlFactory)
    {
        $this->postCommentGridItemControlFactory = $controlFactory;
    }

    public function createComponentPostCommentGridItemMultiple()
    {
        $items = $this->comments;
        $factory = $this->postCommentGridItemControlFactory;

        if (!$items || !$factory) {
            throw new Exception('Page not found', 404);
        }
        return new Multiplier(function (string $id) use ($items, $factory) {
            return $factory->create($items[(int) $id]);
        });
    }
}