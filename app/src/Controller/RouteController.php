<?php

namespace App\Controller;

use App\Container\ContainerInterface;
use App\Router\RouteMatchInterface;

abstract class RouteController extends AbstractController {

  protected RouteMatchInterface $routeMatch;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setRouteMatch($container->get('route_match'));

    return $instance;
  }

  final public function setRouteMatch(RouteMatchInterface $route_match) {
    $this->routeMatch = $route_match;
  }

}
