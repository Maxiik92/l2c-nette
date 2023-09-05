<?php

declare(strict_types=1);

namespace App\Core;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\TemplateFactory;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class MailSender
{

    public function __construct(
        private TemplateFactory $templateFactory,
        private LinkGenerator $linkGenerator,
        private string $templatePath,
    ) {
    }

    private function createMessage(): Message
    {
        return new Message();
    }

    private function send(Message $message): void
    {
        // if (!Debugger::$productionMode) {
        //     return;
        // }
        $mailer = new SendmailMailer();
        $mailer->send($message);
    }

    public function createLatteTemplate()
    {
        $latte = $this->templateFactory->createTemplate();
        $latte->getLatte()->addProvider('uiControl', $this->linkGenerator);
        return $latte;
    }

    public function sendPostInserted(array $values)
    {
        $message = $this->createMessage();
        $message->setFrom('default@l2c.sk');
        $message->addTo('tomas.max@activenet.sk');

        $latte = $this->createLatteTemplate();
        $message->setHtmlBody(
            $latte->renderToString($this->templatePath . 'addPostMail.latte', $values)
        );

        $this->send($message);
    }

}