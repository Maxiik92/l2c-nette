<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\Database\Explorer;

class TranslateModel extends BaseModel
{
	use Nette\SmartObject;

	public function __construct(
		private Explorer $database,
		private Storage $storage
	) {
		parent::__construct($database, $storage);
	}

	public function getTableName(): string
	{
		return 'translate';
	}

	public function getTranslateTable(): object
	{
		$key = 'translate';
		$translate = $this->getCache()->load($key, function (&$dependencies) {
			$dependencies[Cache::Expire] = '1 day';
			$data = $this->getTranslateObject();

			if (!$data) {
				return $data;
			}
			return $data;
		});
		return (object) $translate;
	}

	public function getTranslateObject(): ?object
	{
		$data = $this->getTable()->fetchAll();
		if (!$data) {
			return null;
		}
		$object = (object) array();
		foreach ($data as $row) {
			$name = $row['name'];
			$lang = $row['language'];
			$val = $row['value'];
			if (!isset($object->$name)) {
				$object->$name = (object) array();
			}
			$object->$name->$lang = $val;
		}
		return $object;
	}
}