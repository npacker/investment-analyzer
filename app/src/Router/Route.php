<?php

namespace App\Router;

use App\Http\Request;

interface Route {

  public function path();

  public function controller();

  public function action();

  public function methods();

  public function match(Request $request);

}
