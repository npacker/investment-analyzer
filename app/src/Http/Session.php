<?php

namespace App\Http;

use RuntimeException;

final class Session {

  private array $storage = [];

  private array $options = [];

  private bool $started = false;

  public function __construct(array $options = []) {
    $this->options += [
      'use_strict_mode' => 1,
      'use_cookies' => 1,
      'use_only_cookies' => 1,
      'cookie_httponly' => 1,
      'cookie_lifetime' => 0,
      'use_trans_sid' => 0,
    ];

    session_register_shutdown();
  }

  public function start() {
    if ($this->started) {
      return true;
    }

    $this->started = session_start($this->options);
    $this->storage = &$_SESSION;
  }

  public function started(): bool {
    return $this->started;
  }

  public function name(): string {
    return session_name();
  }

  public function regenerate(): bool {
    return session_regenerate_id();
  }

  public function reset(): bool {
    return session_reset();
  }

  public function save() {
    if ($this->started) {
      session_write_close();
    }
  }

  public function get(string $name) {
    return $this->storage[$name];
  }

  public function has(string $name): bool {
    return array_key_exists($name, $this->storage);
  }

  public function set(string $name, $value) {
    if ($this->started) {
      $this->storage[$name] = $value;
    }
    else {
      throw new RuntimeException('Tried to write to a closed session.');
    }
  }

  public function remove(string $name) {
    if ($this->started) {
      unset($this->storage[$name]);
    }
    else {
      throw new RuntimeException('Tried to write to a closed session.');
    }
  }

}
