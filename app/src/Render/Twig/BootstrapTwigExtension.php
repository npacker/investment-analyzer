<?php

namespace App\Render\Twig;

use App\Messenger\MessengerInterface;
use Twig\Extension\AbstractExtension as TwigAbstractExtension;
use Twig\Extension\GlobalsInterface as TwigGlobalsInterface;

final class BootstrapTwigExtension extends TwigAbstractExtension implements TwigGlobalsInterface {

  private MessengerInterface $messenger;

  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  public function getGlobals(): array {
    return [
      'messenger' => $this->messenger,
    ];
  }

}
