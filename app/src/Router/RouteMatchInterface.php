<?php

namespace App\Router;

interface RouteMatchInterface {

  public function route();

  public function parameters();

  public function success();

}
