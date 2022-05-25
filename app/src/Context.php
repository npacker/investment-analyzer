<?php

namespace App;

use App\Http\RequestInterface;
use App\Router\RouteCollection;
use App\Settings;

final class Context {

  private App $app;

  private RequestInterface $request;

  public function __construct(App $app, RequestInterface $request) {
    $this->app = $app;
    $this->request = $request;
  }

  public function request(): RequestInterface {
    return $this->request;
  }

  public function settings(): Settings {
    return $this->app->settings();
  }

  public function routes(): RouteCollection {
    return $this->app->routes();
  }

}
