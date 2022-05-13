<?php

namespace App\Router;

final class EscapedRoutePathFactory implements EscapedRoutePathFactoryInterface {

  public function create(string $path) {
    return new EscapedRoutePath($path);
  }

}
