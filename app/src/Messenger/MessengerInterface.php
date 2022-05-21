<?php

namespace App\Messenger;

interface MessengerInterface {

  public const TYPE_STATUS = 'status';

  public const TYPE_WARNING = 'warning';

  public const TYPE_ERROR = 'error';

  public function set(string $message, string $type = self::TYPE_STATUS): void;

  public function all(): array;

}
