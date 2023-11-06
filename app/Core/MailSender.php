<?php

declare(strict_types=1);

namespace App\Core;

use App\Model\SettingModel;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\TemplateFactory;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class MailSender
{

    public function __construct(
        private TemplateFactory $templateFactory,
        private LinkGenerator $linkGenerator,
		private SettingModel $settingModel,
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
        $message->setFrom($this->settingModel->getSettingOf('EMAIL_SENDER'));
        $message->addTo($this->settingModel->getSettingOf('EMAIL_RECEIVER'));

        $latte = $this->createLatteTemplate();
        $message->setHtmlBody(
            $latte->renderToString($this->templatePath . 'addPostMail.latte', $values)
        );

        $this->send($message);
    }

}