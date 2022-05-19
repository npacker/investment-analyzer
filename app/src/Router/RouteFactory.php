<?php

namespace App\Router;

use App\Router\RouteFactoryInterface;
use App\Router\RouteInterface;
use App\Router\RoutePatternFactoryInterface;

final class RouteFactory implements RouteFactoryInterface {

  private RoutePatternFactoryInterface $patternFactory;

  public function __construct(RoutePatternFactoryInterface $pattern_factory) {
    $this->patternFactory = $pattern_factory;
  }

  public function create(string $path, string $controller, string $action, array $methods = null): RouteInterface {
    $pattern = $this->patternFactory->create($path);

    return new Route($pattern, $controller, $action, $methods);
  }

}
