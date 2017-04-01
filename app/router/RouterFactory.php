<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\SimpleRouter;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$router[] = new SimpleRouter('Homepage:default');

//		if (isset($_SERVER['NETTE_HTACCESS'])) {
//			$router[] = new Route('nastenka', 'Thread:default');
//			$router[] = new Route('nastenka/archiv', 'Thread:archive');
//			$router[] = new Route('diskuse[/<id>]', 'Thread:show');
//			$router[] = new Route('diskuse-k-akcim', 'Thread:eventThreads');
//			$router[] = new Route('kalendar', 'Event:calendar');
//			$router[] = new Route('akce', 'Event:default');
//			$router[] = new Route('akce/<id>', 'Event:show');
//			$router[] = new Route('lidi', 'Profile:default');
//			$router[] = new Route('clovek[/<id>]', 'Profile:show');
//
//
//			$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
//		} else {
//			$router = new SimpleRouter('Homepage:default');
//		}




		return $router;
	}

}
