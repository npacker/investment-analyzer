<?php

namespace App\Model\Storage;

interface PortfolioStorageInterface {

  public function all(): array;

  public function find(int $id);

  public function create(string $name): string;

  public function update(int $id, string $name): int;

  public function delete(int $id): int;

}
