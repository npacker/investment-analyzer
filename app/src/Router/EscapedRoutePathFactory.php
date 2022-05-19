<?php

namespace App\Router;

use App\PatternMatching\EscapedInterface;
use App\Router\EscapedRoutePathFactoryInterface;

final class EscapedRoutePathFactory implements EscapedRoutePathFactoryInterface {

  public function create(string $path): EscapedInterface {
    return new EscapedRoutePath($path);
  }

}
