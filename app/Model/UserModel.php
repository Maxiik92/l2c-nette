<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Table\Selection;


final class UserModel extends BaseModel
{
	use Nette\SmartObject;

	public function getTableName():string{
		return 'user';
	}


}