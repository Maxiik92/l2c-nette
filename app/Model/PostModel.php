<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Entity\PostResource;
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
	public function getPublicArticles(int $limit = null, ?int  $authorId = null )
	{
		$retVal = $this->getTable()
			->where('created_at < ', new \DateTime)
			->order('created_at DESC')
			->limit($limit);
		
		if ($authorId) {
			$retVal->where('author_id',$authorId);
		}

		return $retVal;
	}

	public function insert(array $values): ActiveRow
	{
		$retval = parent::insert($values);

		$this->mailSender->sendPostInserted($retval->toArray());
		return $retval;
	}

	public function toEntity(ActiveRow $row): PostResource
	{
		return PostResource::create($this->getTableName(), $row);
	}

}