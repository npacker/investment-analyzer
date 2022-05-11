<?php

namespace App\Controller;

use App\App;
use App\Controller\Controller;

abstract class AbstractController implements Controller {

  protected $app;

  public function __construct(App $app) {
    $this->app = $app;
  }

}
