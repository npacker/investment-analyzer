<?php

namespace App\Storage;

interface SecurityStorageInterface {

  public function all(): array;

  public function find(string $symbol): array;

  public function create(string $symbol, string $name): int;

  public function delete(string $symbol): int;

}
