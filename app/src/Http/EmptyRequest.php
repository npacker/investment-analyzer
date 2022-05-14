<?php

namespace App\Http;

use App\Http\Request;

class EmptyRequest implements RequestInterface {

  protected $headers;

  protected $get;

  protected $post;

  protected $server;

  protected $cookie;

  protected $files;

  protected $path;

  public function __construct(array $headers = [], array $get = [], array $post = [], array $server = [], array $cookie = [], array $files = [], string $path = '') {
    $this->headers = $headers;
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->cookie = $cookie;
    $this->files = $files;
    $this->path = $path;
  }

  public function headers(string $name) {
    return $this->headers[strtolower($name)];
  }

  public function get(string $name) {
    return $this->get[$name] ?? null;
  }

  public function post(string $name) {
    return $this->post[$name] ?? null;
  }

  public function server(string $name) {
    return $this->server[$name] ?? null;
  }

  public function cookie(string $name) {
    return $this->cookie[$name] ?? null;
  }

  public function files(string $name) {
    return $this->cookie[$name] ?? null;
  }

  public function path() {
    return $this->path;
  }

}
