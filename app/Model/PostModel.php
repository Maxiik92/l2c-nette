<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use App\Core\MailSender;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;



final class PostModel extends BaseModel
{
	use Nette\SmartObject;

	public function __construct(
		private Explorer $database,
		private MailSender $mailSender,
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

		$this->mailSender->sendPostInserted($retval->toArray());
		return $retval;
	}

}