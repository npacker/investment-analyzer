<?php

namespace App\Serialization;

use Symfony\Component\Yaml\Parser;

final class YamlSymfony implements SerializedInterface {

  public function decode($data) {
    $yaml = new Parser();

    return $yaml->parse($data);
  }

}
