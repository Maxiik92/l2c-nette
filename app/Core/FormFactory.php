<?php

declare(strict_types=1);

namespace App\Core;
use Nette\Application\UI\Form;

Class FormFactory {
    public function create():Form{
        $form = new Form();
        $form->getElementPrototype()
            ->setAttribute('novalidate','novalidate')
            ->setAttribute('class','ajax');
        return $form;
    }
}