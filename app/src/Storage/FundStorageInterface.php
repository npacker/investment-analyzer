<?php

namespace App\Storage;

interface FundStorageInterface {

  public function create(string $symbol, string $name);

  public function delete(string $symbol);

}
