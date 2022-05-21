<?php

namespace App\Http;

interface SessionInterface {

  public function start();

  public function started(): bool;

  public function name(): string;

  public function regenerate(): bool;

  public function reset(): bool;

  public function save();

  public function &get(string $name);

  public function has(string $name): bool;

  public function set(string $name, $value);

  public function remove(string $name);

}
