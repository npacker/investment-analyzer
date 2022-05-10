<?php

namespace App\Http;

interface Request {

  public function headers(string $name): array;

  public function get(string $name);

  public function post(string $name);

  public function server(string $name);

  public function cookie(string $name);

  public function files(string $name);

  public function path(): string;

}
