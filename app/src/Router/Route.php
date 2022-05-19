<?php

namespace App\Router;

use App\Http\RequestInterface;
use App\Router\RequestMatchingInterface;
use App\Router\RouteInterface;
use App\Router\RouteMatchInterface;
use App\Router\RoutePatternInterface;

final class Route implements RouteInterface, RequestMatchingInterface {

  private RoutePatternInterface $pattern;

  private string $controller;

  private string $action;

  private array $methods;

  public function __construct(RoutePatternInterface $pattern, string $controller, string $action, array $methods = null) {
    $this->pattern = $pattern;
    $this->controller = $controller;
    $this->action = $action;
    $this->methods = $methods ?? ['GET'];
  }

  public function path(): string {
    return $this->pattern->raw();
  }

  public function controller(): string {
    return $this->controller;
  }

  public function action(): string {
    return $this->action;
  }

  public function methods(): array {
    return $this->methods;
  }

  public function match(RequestInterface $request): RouteMatchInterface {
    if (in_array($request->server('REQUEST_METHOD'), $this->methods)) {
      return $this->matchPattern($request);
    }
    else {
      return new RouteMatch($this, [], false);
    }
  }

  private function matchPattern(RequestInterface $request): RouteMatchInterface {
    $labels = $this->pattern->labels();
    preg_match($this->pattern, $request->path(), $match);
    $values = array_slice($match, 1);
    $parameters = [];

    foreach ($values as $index => $value) {
      $parameters[$labels[$index]] = $values[$index];
    }

    return new RouteMatch($this, $parameters, (bool) $match);
  }

}
