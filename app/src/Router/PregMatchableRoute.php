<?php

namespace App\Router;

use App\Http\RequestInterface;

final class PregMatchableRoute implements RouteInterface {

  private $pattern;

  private $controller;

  private $action;

  public function __construct(RoutePatternInterface $pattern, string $controller, string $action) {
    $this->pattern = $pattern;
    $this->controller = $controller;
    $this->action = $action;
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
    return [];
  }

  public function match(RequestInterface $request) {
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
