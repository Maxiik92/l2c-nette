<?php

declare(strict_types=1);

namespace App\Model;

use Nette;

use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;
use Nette\DI\Attributes\Inject;
use stdClass;


abstract class BaseModel
{
	use Nette\SmartObject;

	private ?Cache $cache = null;
	#[Inject] private Storage $storage;

	public function __construct(
		private Explorer $database,
	) {
	}

	public abstract function getTableName(): string;

	public function getTable()
	{
		return $this->database->table($this->getTableName());
	}

	public static function fetchAllToObject(array $table): object|null
	{
		$object = null;
		foreach ($table as $key => $row) {
			$class = new stdClass;
			foreach ($row as $index => $value) {
				$class->$index = $value;
			}
			$object[$key] = $class;
		}
		return (object) $object;
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

	protected function getCache(): Cache
	{
		if ($this->cache == null) {
			return new Cache($this->storage);
		} else {
			return $this->cache;
		}
	}
}