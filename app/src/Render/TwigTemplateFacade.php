<?php

namespace App\Render;

use App\Render\AbstractTemplateFacade;
use Twig\TemplateWrapper as TwigTemplate;

final class TwigTemplateFacade extends AbstractTemplateFacade {

  private TwigTemplate $template;

  public function __construct(TwigTemplate $template) {
    $this->template = $template;
  }

  public function render(): string {
    return $this->template->render($this->variables);
  }

}
