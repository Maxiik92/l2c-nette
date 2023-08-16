<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Table\ActiveRow;


final class UserModel extends BaseModel
{
	use Nette\SmartObject;

	public function getTableName(): string
	{
		return 'user';
	}

	public function getByEmail(string $email): ?ActiveRow
	{
		return $this->getTable()
			->where('email', $email)
			->fetch();
	}


}