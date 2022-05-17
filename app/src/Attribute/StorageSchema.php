<?php

namespace App\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class StorageSchema {

  public string $class;

  public function __construct(string $class) {
    $this->class = $class;
  }

}
