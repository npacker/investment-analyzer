<?php

namespace App\Http;

interface ResponseInterface {

  public function __toString(): string;

  public function status(): int;

  public function headers(): array;

  public function send();

  public function sendContent();

  public function sendHeaders();

}
