<?php

namespace App\Stream;

final class FileLinesAsCsv implements \Iterator {

  private string $path;

  private int $length;

  private $handle;

  private int $position;

  private array $fields;

  private $current;

  public function __construct(string $path, int $length = 80) {
    $this->path = $path;
    $this->length = $length;
  }

  public function __destruct() {
    fclose($this->handle);
  }

  public function current() {
    return array_combine($this->fields, $this->current);
  }

  public function key() {
    return $this->position;
  }

  public function next(): void {
    ++$this->position;
  }

  public function rewind(): void {
    if (!is_resource($this->handle)) {
      $this->handle = fopen($this->path, 'r');
    }

    rewind($this->handle);

    $this->position = 0;
    $this->fields = fgetcsv($this->handle, $this->length);
  }

  public function valid(): bool {
    $this->current = fgetcsv($this->handle, $this->length);

    return ($this->current !== false);
  }

}
