<?php

namespace App\Render;

use App\Render\TemplateFacadeInterface;
use Twig\Environment as TwigEnvironment;

final class TwigTemplateFactory implements TemplateFactoryInterface {

  private TwigEnvironment $twig;

  public function __construct(TwigEnvironment $twig) {
    $this->twig = $twig;
  }

  public function load(string $name): TemplateFacadeInterface {
    return new TwigTemplateFacade($this->twig->load($name));
  }

}
