<?php

namespace App\Router;

use App\Router\RouteInterface;

interface RouteMatchInterface {

  public function route(): RouteInterface;

  public function parameters(): array;

  public function success(): bool;

}
