<?php

namespace App\Router;

use App\Http\Request;
use App\Router\NonMatchingRouteException;
use App\Router\PregRoutePattern;
use App\Router\RouteMatch;

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
    $pattern = (string) new PregRoutePattern($this->path);
    preg_match_all('/{([^\/]+)}/', $this->path, $labels);
    $labels = array_values(end(array_slice($labels, 1)));
    preg_match($pattern, $request->path(), $match);
    $values = array_slice($match, 1);
    $parameters = [];

    foreach ($values as $index => $value) {
      $parameters[$labels[$index]] = $values[$index];
    }

    return new RouteMatch($this, $parameters, (bool) $match);
  }

}
