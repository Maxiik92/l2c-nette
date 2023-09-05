<?php

declare(strict_types=1);

namespace App\Router;

use App\AdminModule\Router\RouterFactory as AdminRouterFactory;
use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->add(AdminRouterFactory::createRouter())
			->addRoute('editPost/<postId>', 'Post:edit')
			->addRoute('createPost', 'Post:add')
			->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}