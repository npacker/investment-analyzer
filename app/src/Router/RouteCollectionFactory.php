<?php

namespace App\Router;

final class RouteCollectionFactory {

  private $routeFactory;

  public function __construct(RouteFactory $route_factory) {
    $this->routeFactory = $route_factory;
  }

  public function create($data) {
    $routes = [];

    foreach ($data as $name => $parameters) {
      extract($parameters);

      $routes[] = $this->routeFactory->create($path, $controller, $action, $methods ?? ['GET']);
    }

    return new RouteCollection(...$routes);
  }

}
