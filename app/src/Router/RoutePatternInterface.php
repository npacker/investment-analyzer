<?php

namespace App\Router;

interface RoutePatternInterface {

  public function __toString();

  public function raw();

  public function labels();

}
