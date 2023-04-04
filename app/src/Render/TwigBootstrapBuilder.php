<?php

namespace App\Render;

use App\Messenger\MessengerInterface;
use App\Render\Twig\BootstrapTwigExtension;
use App\Settings;
use Twig\Environment as TwigEnvironment;

final class TwigBootstrapBuilder implements TemplateEngineBuilderInterface {

  private MessengerInterface $messenger;

  private Settings $settings;

  public function __construct(TwigEnvironment $twig, MessengerInterface $messenger, Settings $settings) {
    $this->twig = $twig;
    $this->messenger = $messenger;
    $this->settings = $settings;
  }

  public function build() {
    $this->twig->addExtension(new BootstrapTwigExtension($this->messenger, $this->settings));
  }

}
