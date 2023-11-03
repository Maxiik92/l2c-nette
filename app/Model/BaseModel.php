<?php

declare(strict_types=1);

namespace App\Model;

use Nette;

use Nette\Database\Explorer;


abstract class BaseModel
{
	use Nette\SmartObject;

	public function __construct(
		private Explorer $database
	) {
	}

	public abstract function getTableName(): string;

	public function getTable()
	{
		return $this->database->table($this->getTableName());
	}

	public function getById(int $id)
	{
		return $this->getTable()
			->get($id);
	}

	public function update(int $id, array $data)
	{
		$numId = intval($id);
		$item = $this->getById($numId);
		$item->update($data);
		return $item;
	}

	public function insert(array $data)
	{
		return $this->getTable()->insert($data);
	}

	public function delete(int $id)
	{
		return $this->getById($id)->delete();
	}
}