<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Entity\CommentResource;
use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;


final class CommentModel extends BaseModel
{
	use Nette\SmartObject;

	public function getTableName():string{
		return 'comment';
	}

	public function getCommentsByPostId(int $postId, int $limit = null): Selection
	{
		return $this->getTable()
			->where('post_id', $postId)
			->order('created_at')
			->limit($limit);
	}

	public function toEntity(ActiveRow $row): CommentResource
	{
		return CommentResource::create($this->getTableName(), $row);
	}
}