<?php

namespace App\Container;

interface ServiceDefinitionInterface {

  public function name(): string;

  public function class(): string;

  public function arguments(): array;

  public function shared(): bool;

}
