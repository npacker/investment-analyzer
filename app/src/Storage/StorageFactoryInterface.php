<?php

namespace App\Storage;

use App\Storage\FundStorageInterface;
use App\Storage\FundPositionStorageInterface;

interface StorageFactoryInterface {

  public function getFundStorage(): FundStorageInterface;

  public function getFundPositionStorage(): FundPositionStorageInterface;

}
