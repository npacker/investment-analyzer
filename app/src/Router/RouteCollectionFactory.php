<?php

namespace App\Router;

final class RouteCollectionFactory {

  private $routeFactory;

  public function __construct(RouteFactoryInterface $route_factory) {
    $this->routeFactory = $route_factory;
  }

  public function create($data) {
    $routes = new RouteCollection();

    foreach ($data as $name => $parameters) {
      extract($parameters);

      $routes->add($name, $this->routeFactory->create($path, $controller, $action, $methods ?? ['GET']));
    }

    return $routes;
  }

}
