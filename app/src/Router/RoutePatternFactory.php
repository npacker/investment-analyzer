<?php

namespace App\Router;

interface RoutePatternFactory {

  public function create(string $path);

}
