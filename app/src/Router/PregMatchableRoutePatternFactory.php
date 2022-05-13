<?php

namespace App\Router;

final class PregMatchableRoutePatternFactory implements RoutePatternFactoryInterface {

  private $factory;

  public function __construct(RouteEscapedFactoryInterface $factory) {
    $this->factory = $factory;
  }

  public function create(string $path) {
    $escape = $this->factory->create($path);

    return new PregMatchableRoutePattern($escape);
  }

}
