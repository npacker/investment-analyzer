<?php

namespace App\Storage;

interface SecurityStorageInterface {

  public function find(string $symbol);

  public function create(string $symbol, string $name): int;

  public function delete(string $symbol): int;

}
