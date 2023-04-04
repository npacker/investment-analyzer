<?php

namespace App\Render\Twig;

use App\Messenger\MessengerInterface;
use App\Settings;
use Twig\Extension\AbstractExtension as TwigAbstractExtension;
use Twig\Extension\GlobalsInterface as TwigGlobalsInterface;

final class BootstrapTwigExtension extends TwigAbstractExtension implements TwigGlobalsInterface {

  private MessengerInterface $messenger;

  private Settings $settings;

  public function __construct(MessengerInterface $messenger, Settings $settings) {
    $this->messenger = $messenger;
    $this->settings = $settings;
  }

  public function getGlobals(): array {
    return [
      'messenger' => $this->messenger,
      'settings' => $this->settings,
    ];
  }

}
