<?php

namespace App\Router;

final class PregMatchableRouteEscapedFactory implements RouteEscapedFactory {

  public function create(string $path) {
    return new PregMatchableRouteEscaped($path);
  }

}
