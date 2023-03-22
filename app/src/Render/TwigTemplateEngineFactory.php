<?php

namespace App\Render;

use App\Messenger\MessengerInterface;
use App\Render\TemplateEngineInterface;
use App\Render\Twig\BootstrapTwigExtension;
use Twig\Environment as TwigEnvironment;

final class TwigTemplateEngineFactory implements TemplateEngineFactoryInterface {

  private TwigEnvironment $twig;

  private MessengerInterface $messenger;

  public function __construct(TwigEnvironment $twig, MessengerInterface $messenger) {
    $this->twig = $twig;
    $this->messenger = $messenger;
  }

  public function initialize(): void {
    $this->twig->addExtension(new BootstrapTwigExtension($this->messenger));
  }

}
