<?php

namespace App\Database\MySql;

use App\Database\FundDataAccessObjectInterface;

final class MySqlFundDataAccessObject extends MySqlDataAccessObject implements FundDataAccessObjectInterface {

  public function create(string $symbol, string $name) {}

  public function delete(string $symbol) {}

}
