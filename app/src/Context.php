<?php

namespace App;

use App\Http\Request;

final class Context {

  private $request;

  private $app;

  public function __construct(Request $request, App $app) {
    $this->request = $request;
    $this->app = $app;
  }

  public function request() {
    return $this->request;
  }

  public function settings() {
    return $this->app->settings();
  }

  public function routes() {
    return $this->app->routes();
  }

  public function baseUrl() {
    static $base_url;

    if (!isset($base_url)) {
      $scheme = $this->request->server('REQUEST_SCHEME');
      $host = $this->request->server('HTTP_HOST');
      $base_url = $scheme . '://' . $host;
    }

    return $base_url;
  }

}
