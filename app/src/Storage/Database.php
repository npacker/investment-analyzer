<?php

namespace App\Storage;

use App\Settings;

final class Database {

  private $hostname;

  private $username;

  private $password;

  private $database;

  private $pdo;

  public function __construct(Settings $settings) {
    $this->hostname = $settings->database['hostname'];
    $this->username = $settings->database['username'];
    $this->password = $settings->database['password'];
    $this->database = $settings->database['database'];
  }

  public function getInstance() {
    if (!isset($this->pdo)) {
      $this->pdo = new PDO("mysql:host={$this->hostname};dbname={$this->database}", $this->username, $this->password);
    }

    return $this->pdo;
  }

}
