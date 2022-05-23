<?php

namespace App\Storage;

interface FundPositionStorageInterface {

  public function all(): array;

  public function create(string $fund, string $security, string $weight): int;

  public function delete(string $fund, string $security): int;

}
