<?php

namespace App\Router;

use App\Http\Request;
use App\Router\HttpRoute;
use App\Router\PregMatchableRoute;
use App\Router\RequestMatching;
use App\Router\Route;
use App\Router\RouteMatch;
use App\Router\RouteNotFoundException;

final class RouteCollection implements RequestMatching {

  private $routes;

  public static function initialize($config) {
    $routes = [];

    foreach ($config as $name => $parameters) {
      extract($parameters);

      $routes[] = new HttpRoute(new PregMatchableRoute($path, $controller, $action), $methods ?? ['GET']);
    }

    return new self(...$routes);
  }

  public function __construct(Route ...$routes) {
    $this->routes = $routes;
  }

  public function match(Request $request) {
    foreach ($this->routes as $route) {
      $match = $route->match($request);

      if ($match->success()) {
        return $match;
      }
    }

    throw new RouteNotFoundException('Not Found.');
  }

}
