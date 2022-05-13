<?php

namespace App\Router;

interface RoutePatternFactoryInterface {

  public function create(string $path);

}
