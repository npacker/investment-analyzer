<?php

namespace App\Router;

use App\Http\RequestInterface;

interface RequestMatchingInterface {

  public function match(RequestInterface $request);

}
