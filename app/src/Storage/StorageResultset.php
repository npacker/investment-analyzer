<?php

namespace App\Storage;

final class StorageResultset implements \Iterator, \Coutnable {

  private $objects = [];

  private $array;

  private $position;

  public function __construct(array $result = []) {
    $this->array = $result;
    $this->position = 0;
  }

  public function rewind() {
    $this->position = 0;
  }

  public function current() {
    if (!isset($this->objects[$this->position])) {
      $this->objects[$this->position] = (object) $this->array[$this->position];
    }

    return $this->objects[$this->position];
  }

  public function key() {
    return $this->position;
  }

  public function next() {
    ++$this->position;
  }

  public function valid() {
    return isset($this->array[$this->position]);
  }

  public function count() {
    return count($this->array);
  }

  public function empty() {
    return ((bool) $this->count()) === false;
  }

}
