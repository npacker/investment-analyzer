<?php

namespace App\Router;

use App\Http\RequestInterface;

interface RouteInterface {

  public function path();

  public function controller();

  public function action();

  public function methods();

  public function match(RequestInterface $request);

}
