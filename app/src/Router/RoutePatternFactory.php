<?php

namespace App\Router;

use App\Router\EscapedRoutePathFactoryInterface;
use App\Router\RoutePatternInterface;

final class RoutePatternFactory implements RoutePatternFactoryInterface {

  private EscapedRoutePathFactoryInterface $factory;

  public function __construct(EscapedRoutePathFactoryInterface $factory) {
    $this->factory = $factory;
  }

  public function create(string $path): RoutePatternInterface {
    $escape = $this->factory->create($path);

    return new RoutePattern($escape);
  }

}
