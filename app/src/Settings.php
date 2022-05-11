<?php

namespace App;

final class Settings {

  private $storage;

  public function __construct($settings = []) {
    $this->storage = $settings;
  }

  public function __get($key) {
    return $this->storage[$key];
  }

}
