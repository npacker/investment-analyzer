<?php

namespace App\Router;

use App\PatternMatching\PatternInterface;

interface RoutePatternInterface extends PatternInterface {

  public function labels(): array;

}
