<?php

namespace App\Render;

use App\Messenger\MessengerInterface;
use App\Render\TemplateEngineInterface;
use App\Render\Twig\BootstrapTwigExtension;
use App\Render\Twig\RuntimeTwigExtension;
use App\Settings;
use Twig\Environment as TwigEnvironment;

final class TwigTemplateEngineFactory implements TemplateEngineFactoryInterface {

  private TwigEnvironment $twig;

  private MessengerInterface $messenger;

  private Settings $settings;

  public function __construct(TwigEnvironment $twig, MessengerInterface $messenger, Settings $settings) {
    $this->twig = $twig;
    $this->messenger = $messenger;
    $this->settings = $settings;
  }

  public function bootstrap(): void {
    $this->twig->addExtension(new BootstrapTwigExtension($this->messenger));
  }

}
