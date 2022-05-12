<?php

namespace App\Router;

final class PregMatchableRoutePatternFactory implements RoutePatternFactory {

  private $factory;

  public function __construct(RouteEscapedFactory $factory) {
    $this->factory = $factory;
  }

  public function create(string $path) {
    $escape = $this->factory->create($path);

    return new PregMatchableRoutePattern($escape);
  }

}
