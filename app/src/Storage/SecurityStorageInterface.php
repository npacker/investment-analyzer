<?php

namespace App\Storage;

interface SecurityStorageInterface {

  public function create(string $symbol);

  public function delete(string $symbol);

}
