<?php

namespace App;

use App\AppInterface;

interface EnvironmentInterface {

  public function root(): string;

  public function bootstrap(): AppInterface;

}
