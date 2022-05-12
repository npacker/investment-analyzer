<?php

namespace App\Router;

use App\Http\Request;

interface RequestMatching {

  public function match(Request $request);

}
