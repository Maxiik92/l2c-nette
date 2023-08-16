<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Application\LinkGenerator;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


final class PostModel extends BaseModel
{
	use Nette\SmartObject;

	public function __construct(
		private Explorer $database,
		private TemplateFactory $templateFactory,
		private LinkGenerator $linkGenerator
	) {
		parent::__construct($database);
	}

	public function getTableName(): string
	{
		return 'post';
	}
	public function getPublicArticles(int $limit = null)
	{
		return $this->getTable()
			->where('created_at < ', new \DateTime)
			->order('created_at DESC')
			->limit($limit);
	}

	public function insert(array $values): ActiveRow
	{
		$retval = parent::insert($values);

		//mail send 

		// if(Debugger::$productionMode){
		// 	$latte = $this->templateFactory->createTemplate();
		// 	$latte->getLatte()->addProvider('uiControl',$this->linkGenerator);

		// 	$message = new Message();
		// 	$message->setFrom('default@l2c.sk');
		// 	$message->addTo('tomas.max@activenet.sk');
		// 	$message->setHtmlBody($latte->renderToString(__DIR__.'addPostMail.latte',$retval->toArray()));
		// 	$sender = new SendmailMailer();
		// 	$sender->send($message);
		// }
		return $retval;
	}

}