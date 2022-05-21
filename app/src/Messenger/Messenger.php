<?php

namespace App\Messenger;

use App\Http\SessionInterface;
use App\Messenger\MessengerInterface;

final class Messenger implements MessengerInterface {

  private SessionInterface $session;

  public function __construct(SessionInterface $session) {
    $this->session = $session;
  }

  public function set(string $message, string $type = MessengerInterface::TYPE_STATUS): void {
    if (!$this->session->has('messages')) {
      $this->session->set('messages', []);
    }

    $messages = $this->session->get('messages');

    if (!isset($messages[$type])) {
      $messages[$type] = [];
    }

    $messages[$type][] = $message;

    $this->session->set('messages', $messages);
  }

  public function all(): array {
    $messages = $this->session->get('messages') ?? [];

    $this->session->remove('messages');

    return $messages;
  }

}
