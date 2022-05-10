<?php

namespace App;

use App\Http\Request;

final class App {

  private $settings;

  private $request;

  private $twig;

  public function __construct(array $settings, Request $request, \Twig\Environment $twig) {
    $this->settings = $settings;
    $this->request = $request;
    $this->twig = $twig;

    $this->twig->addGlobal('app', $this);
  }

  public function settings() {
    return $this->settings;
  }

  public function request() {
    return $this->request;
  }

  public function twig() {
    return $this->twig;
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
