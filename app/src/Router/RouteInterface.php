<?php

namespace App\Router;

interface RouteInterface {

  public function path();

  public function controller();

  public function action();

  public function methods();

}
