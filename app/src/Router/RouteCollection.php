<?php

namespace App\Router;

use App\Http\RequestInterface;

final class RouteCollection implements RequestMatchingInterface {

  private $routes = [];

  public function add(string $name, RouteInterface $route) {
    $this->routes[$name] = $route;
  }

  public function remove(string $name) {
    unset($this->routes[$name]);
  }

  public function match(RequestInterface $request) {
    foreach ($this->routes as $route) {
      $match = $route->match($request);

      if ($match->success()) {
        return $match;
      }
    }

    throw new RouteNotFoundException();
  }

}
