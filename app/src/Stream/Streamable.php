<?php

namespace App\Stream;

interface Streamable {

  public function read(): string;

}
