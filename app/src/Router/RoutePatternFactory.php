<?php

namespace App\Router;

final class RoutePatternFactory implements RoutePatternFactoryInterface {

  private $factory;

  public function __construct(EscapedRoutePathFactoryInterface $factory) {
    $this->factory = $factory;
  }

  public function create(string $path) {
    $escape = $this->factory->create($path);

    return new RoutePattern($escape);
  }

}
