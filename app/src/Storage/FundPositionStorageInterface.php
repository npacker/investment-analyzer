<?php

namespace App\Storage;

interface FundPositionStorageInterface {

  public function create(string $fund, string $security, string $weight);

  public function delete(string $fund, string $security);

}
