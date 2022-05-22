<?php

namespace App\Router;

use App\Http\RequestInterface;
use App\Router\RequestMatchingInterface;
use App\Router\RouteInterface;
use App\Router\RouteMatchInterface;

final class RouteCollection implements RequestMatchingInterface {

  private array $routes = [];

  public function add(string $name, RequestMatchingInterface $route): void {
    $this->routes[$name] = $route;
  }

  public function has(string $name): bool {
    return isset($this->routes[$name]);
  }

  public function get(string $name): RouteInterface {
    return $this->routes[$name];
  }

  public function remove(string $name): void {
    unset($this->routes[$name]);
  }

  public function match(RequestInterface $request): RouteMatchInterface {
    foreach ($this->routes as $route) {
      $match = $route->match($request);

      if ($match->success()) {
        return $match;
      }
    }

    throw new RouteNotFoundException();
  }

}
