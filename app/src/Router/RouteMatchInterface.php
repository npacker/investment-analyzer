<?php

namespace App\Router;

use App\Router\RouteInterface;

interface RouteMatchInterface {

  public function route(): RouteInterface;

  public function parameters(?string $name);

  public function success(): bool;

}
