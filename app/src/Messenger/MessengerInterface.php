<?php

namespace App\Messenger;

interface MessengerInterface {

  public const TYPE_STATUS = 'status';

  public const TYPE_WARNING = 'warning';

  public const TYPE_ERROR = 'error';

  public function set(string $message, string $type = self::TYPE_STATUS): void;

  public function setWarning(string $message): void;

  public function setError(string $message): void;

  public function all(): array;

  public function clear(): void;

}
