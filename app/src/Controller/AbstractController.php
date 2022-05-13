<?php

namespace App\Controller;

use App\App;

abstract class AbstractController implements ControllerInterface {

  protected $app;

  public function __construct(App $app) {
    $this->app = $app;
  }

}
