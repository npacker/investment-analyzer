<?php

namespace App\Router;

interface RoutePattern {

  public function __toString();

  public function labels();

}
