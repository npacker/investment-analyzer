<?php

namespace App\Router;

use App\Router\RoutePatternInterface;

interface RoutePatternFactoryInterface {

  public function create(string $path): RoutePatternInterface;

}
