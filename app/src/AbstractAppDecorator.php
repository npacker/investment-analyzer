<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Router\RequestMatchingInterface;
use App\Settings;

abstract class AbstractAppDecorator implements AppInterface {

  protected AppInterface $app;

  public function autoloader() {
    return $this->app->autoloader();
  }

  public function container(): ContainerInterface {
    return $this->app->container();
  }

  public function settings(): Settings {
    return $this->app->settings();
  }

  public function routes(): RequestMatchingInterface {
    return $this->app->routes();
  }

}
