<?php

namespace App\Router;

final class PregMatchableRouteEscapedFactory implements RouteEscapedFactoryInterface {

  public function create(string $path) {
    return new PregMatchableRouteEscaped($path);
  }

}
