<?php

namespace App\Router;

final class PregRouteLabels {

  private $route;

  private $delimiter;

  public function __construct(PregMatchableRoute $route, string $delimiter ='@') {
    $this->route = $route;
    $this->delimiter = $delimiter;
  }

  public function extract() {
    preg_match_all($this->delimiter . '{([^\/]+)}' . $this->delimiter, $this->route->path(), $labels);
    array_shift($labels);

    return array_values(end($labels));
  }

}
