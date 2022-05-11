<?php

namespace App;

use App\Http\Request;

final class Context {

  private $request;

  private $settings;

  public function __construct(Request $request, $settings) {
    $this->request = $request;
    $this->settings = $settings;
  }

  public function request() {
    return $this->request;
  }

  public function settings() {
    return $this->settings;
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
