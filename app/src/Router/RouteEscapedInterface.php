<?php

namespace App\Router;

interface RouteEscapedInterface {

  public function __toString();

  public function raw();

}
