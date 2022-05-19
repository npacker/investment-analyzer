<?php

namespace App\PatternMatching;

interface EscapedInterface {

  public function __toString(): string;

  public function raw(): string;

}
