<?php

namespace App\Router;

use App\Router\RouteCollection;
use App\Router\RouteFactoryInterface;

final class RouteCollectionFactory {

  private RouteFactoryInterface $routeFactory;

  public function __construct(RouteFactoryInterface $route_factory) {
    $this->routeFactory = $route_factory;
  }

  public function create($data): RouteCollection {
    $routes = new RouteCollection();

    foreach ($data as $name => $parameters) {
      $path = $parameters['path'];
      $controller = $parameters['controller'];
      $action = $parameters['action'];
      $methods = $parameters['methods'] ?? null;

      $routes->add($name, $this->routeFactory->create($path, $controller, $action, $methods));
    }

    return $routes;
  }

}
