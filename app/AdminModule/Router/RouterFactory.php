<?php

declare(strict_types=1);

namespace App\AdminModule\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router
			->withModule('Admin') //prefix modulu aby sa nemusel pisat do kazdej cesty
			->withPath('admin') // prefix cesty aby sa nemusela pisat vsetko bude s prefixom admin/
			->addRoute('[<lang=en sk|en>/]login','Sign:in')
			->addRoute('[<lang=en sk|en>/]postdetail/<postId>','Post:show')
			->addRoute('[<lang=en sk|en>/]<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}