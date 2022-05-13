<?php

namespace App\Router;

use App\Http\RequestInterface;

final class Route implements RouteInterface, RequestMatchingInterface {

  private $pattern;

  private $controller;

  private $action;

  private $methods;

  public function __construct(RoutePatternInterface $pattern, string $controller, string $action, array $methods = null) {
    $this->pattern = $pattern;
    $this->controller = $controller;
    $this->action = $action;
    $this->methods = $methods ?? ['GET'];
  }

  public function path() {
    return $this->pattern->raw();
  }

  public function controller() {
    return $this->controller;
  }

  public function action() {
    return $this->action;
  }

  public function methods() {
    return $this->methods;
  }

  public function match(RequestInterface $request) {
    if (in_array($request->server('REQUEST_METHOD'), $this->methods)) {
      return $this->matchPattern($request);
    }
    else {
      return new RouteMatch($this, [], false);
    }
  }

  private function matchPattern(RequestInterface $request) {
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
