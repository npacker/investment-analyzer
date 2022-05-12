<?php

namespace App\Router;

use App\Http\Request;

final class PregMatchableRoute implements Route {

  private $path;

  private $controller;

  private $action;

  public function __construct(string $path, string $controller, string $action) {
    $this->path = $path;
    $this->controller = $controller;
    $this->action = $action;
  }

  public function path() {
    return $this->path;
  }

  public function controller() {
    return $this->controller;
  }

  public function action() {
    return $this->action;
  }

  public function match(Request $request) {
    $pattern = new PregMatchableRoutePattern(new PregMatchableRouteEscaped($this->path));
    $labels = $pattern->labels();
    preg_match($pattern, $request->path(), $match);
    $values = array_slice($match, 1);
    $parameters = [];

    foreach ($values as $index => $value) {
      $parameters[$labels[$index]] = $values[$index];
    }

    return new RouteMatch($this, $parameters, (bool) $match);
  }

}
