<?php

namespace App\Serialization;

use App\Serialization\Serialized;
use Symfony\Component\Yaml\Parser;

final class Yaml implements Serialized {

  private $data;

  public function __construct($data) {
    $this->data = $data;
  }

  public function decode() {
    $yaml = new Parser();

    return $yaml->parse($this->data);
  }

}
