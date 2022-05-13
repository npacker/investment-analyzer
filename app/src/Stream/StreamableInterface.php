<?php

namespace App\Stream;

interface StreamableInterface {

  public function read(): string;

}
