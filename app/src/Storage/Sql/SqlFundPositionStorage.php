<?php

namespace App\Storage\Sql;

final class SqlFundPositionStorage extends SqlStorage implements FundPositionStorageInterface {

  public function create(string $fund, string $security, string $weight) {
  }

  public function delete(string $fund, string $security) {
  }

}
