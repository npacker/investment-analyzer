<?php

namespace App\Model\Storage;

interface FundStorageInterface {

  public function all(): array;

  public function find(string $symbol);

  public function create(string $symbol, string $name): int;

  public function update(string $symbol, string $name): int;

  public function delete(string $symbol): int;

}
