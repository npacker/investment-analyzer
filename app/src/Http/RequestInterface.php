<?php

namespace App\Http;

interface RequestInterface {

  public function headers(string $name): ?string;

  public function get(string $name): ?string;

  public function post(string $name): ?string;

  public function server(string $name): ?string;

  public function cookie(string $name): ?string;

  public function files(string $name): ?array;

  public function path(): string;

}
