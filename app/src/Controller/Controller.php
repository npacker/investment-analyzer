<?php

namespace App\Controller;

use App\Http\Request;

interface Controller {

  public function handle(Request $request);

}
