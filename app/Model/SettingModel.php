<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Caching\Cache;
use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

/**
 * Class SettingModel
 * @package App\Model
 * 
 * @property-read string $EMAIL_SENDER
 * @property-read string $EMAIL_RECEIVER
 * 
 */
class SettingModel extends BaseModel
{
	use Nette\SmartObject;

	public function __construct(
		private Explorer $database,
		private Cache $cache
	) {
		parent::__construct($database);
	}

	public function getTableName(): string
	{
		return 'setting';
	}

	public function getSettingsTable(): object
	{
		$key = 'settings';
		$settings = $this->cache->load($key, function (&$dependencies) {
			$dependencies[Cache::Expire] = '1 day';
			$data = $this->getTable()->fetchAll();

			if (!$data) {
				return $data;
			}
			return BaseModel::fetchAllToObject($data);
		});
		return (object) $settings;
	}

	public function getSettingOf(string $key): string
	{
		return $this->getSettingsTable()->$key->value;
	}

}