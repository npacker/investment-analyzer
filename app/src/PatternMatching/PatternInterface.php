<?php

namespace App\PatternMatching;

interface PatternInterface {

  public function __toString(): string;

  public function raw(): string;

}
