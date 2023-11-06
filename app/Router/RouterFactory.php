<?php

declare(strict_types=1);

namespace App\Router;

use App\AdminModule\Router\RouterFactory as AdminRouterFactory;
use App\FrontModule\Router\RouterFactory as FrontRouterFactory;
use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router
			->add(AdminRouterFactory::createRouter())
			->add(FrontRouterFactory::createRouter())
			->addRoute('[<lang=en sk|en>/]<presenter>/<action>[/<id>]', 'Homepage:default');

		return $router;
	}
}