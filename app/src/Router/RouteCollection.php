<?php

namespace App\Router;

use App\Http\Request;

final class RouteCollection implements RequestMatching {

  private $routes;

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

    throw new RouteNotFoundException();
  }

}
