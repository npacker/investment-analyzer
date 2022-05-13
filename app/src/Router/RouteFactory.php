<?php

namespace App\Router;

final class RouteFactory implements RouteFactoryInterface {

  private $patternFactory;

  public function __construct(RoutePatternFactoryInterface $pattern_factory) {
    $this->patternFactory = $pattern_factory;
  }

  public function create(string $path, string $controller, string $action, array $methods = null) {
    $pattern = $this->patternFactory->create($path);

    return new Route($pattern, $controller, $action, $methods);
  }

}
