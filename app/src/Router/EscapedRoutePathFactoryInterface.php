<?php

namespace App\Router;

use App\PatternMatching\EscapedInterface;

interface EscapedRoutePathFactoryInterface {

  public function create(string $path): EscapedInterface;

}
