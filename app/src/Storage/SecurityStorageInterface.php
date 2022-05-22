<?php

namespace App\Storage;

interface SecurityStorageInterface {

  public function create(string $symbol, string $name);

  public function delete(string $symbol);

}
