<?php

namespace App\Http;

use App\Http\RequestInterface;

class EmptyRequest implements RequestInterface {

  protected array $headers;

  protected array $get;

  protected array $post;

  protected array $server;

  protected array $cookie;

  protected array $files;

  protected string $path;

  public function __construct(array $headers = [], array $get = [], array $post = [], array $server = [], array $cookie = [], array $files = [], string $path = '') {
    $this->headers = $headers;
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->cookie = $cookie;
    $this->files = $files;
    $this->path = $path;
  }

  public function headers(string $name): ?string {
    return $this->headers[strtolower($name)];
  }

  public function get(string $name): ?string {
    return $this->get[$name] ?? null;
  }

  public function post(string $name): ?string {
    return $this->post[$name] ?? null;
  }

  public function server(string $name): ?string {
    return $this->server[$name] ?? null;
  }

  public function cookie(string $name): ?string {
    return $this->cookie[$name] ?? null;
  }

  public function files(string $name): ?array {
    return $this->files[$name] ?? null;
  }

  public function path(): string {
    return $this->path;
  }

}
