<?php

namespace App\Storage\Sql;

use App\Storage\FundStorageInterface;

final class SqlFundStorage extends SqlStorage implements FundStorageInterface {

  public function create(string $symbol, string $name) {}

  public function delete(string $symbol) {}

}
