<?php

namespace App\Router;

use App\Http\Request;

final class RouteCollection implements RequestMatching {

  private $routes = [];

  public function add(string $name, Route $route) {
    $this->routes[$name] = $route;
  }

  public function remove(string $name) {
    unset($this->routes[$name]);
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
