<?php

namespace App\Stream;

use App\Stream\StreamableInterface;

final class LocalReadOnlyFile implements StreamableInterface {

  private $path;

  public function __construct(string $path) {
    $this->path = $path;
  }

  public function read(): string {
    $stream = fopen($this->path, 'r');
    $contents = stream_get_contents($stream);

    fclose($stream);

    return $contents;
  }

}
