<?php

namespace App\Database;

interface FundDataAccessObject {

  public function create(string $symbol, string $name);

  public function delete(string $symbol);

}
