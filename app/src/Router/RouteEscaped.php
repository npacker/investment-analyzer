<?php

namespace App\Router;

interface RouteEscaped {

  public function __toString();

  public function raw();

}
