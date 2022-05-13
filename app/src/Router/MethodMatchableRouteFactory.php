<?php

namespace App\Router;

final class MethodMatchableRouteFactory implements RouteFactoryInterface {

  private $patternFactory;

  public function __construct(RoutePatternFactoryInterface $pattern_factory) {
    $this->patternFactory = $pattern_factory;
  }

  public function create(string $path, string $controller, string $action, array $methods) {
    $pattern = $this->patternFactory->create($path);
    $route = new PregMatchableRoute($pattern, $controller, $action);

    return new MethodMatchableRoute($route, $methods);
  }

}
