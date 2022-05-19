<?php

namespace App\Router;

interface RouteInterface {

  public function path(): string;

  public function controller(): string;

  public function action(): string;

  public function methods(): array;

}
