<?php

declare(strict_types=1);

namespace App\FrontModule\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router
			->withModule('Front') //prefix modulu aby sa nemusel pisat do kazdej cesty
			->addRoute('[<lang=en sk|en>/]editPost/<postId>', 'Post:edit')
			->addRoute('[<lang=en sk|en>/]login','Sign:in')
			->addRoute('[<lang=en sk|en>/]createPost', 'Post:add')
			->addRoute('[<lang=en sk|en>/]<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}