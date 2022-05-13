<?php

namespace App\Database;

interface FundDataAccessObjectInterface {

  public function create(string $symbol, string $name);

  public function delete(string $symbol);

}
