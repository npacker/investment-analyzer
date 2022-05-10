<?php

namespace App\Database\MySql;

use App\Database\FundDataAccessObject;

final class MySqlFundDataAccessObject extends MySqlDataAccessObject implements FundDataAccessObject {

  public function create(string $symbol, string $name) {
  }

  public function delete(string $symbol) {
  }

}
