<?php

namespace App\Controller;

use App\App;
use App\Container\ContainerInterface;
use App\Container\ContainerInjectionInterface;
use App\Controller\ControllerInterface;
use App\Render\TemplateFacadeInterface;
use App\Render\TemplateFactoryInterface;
use App\Messenger\MessengerInterface;

abstract class AbstractController implements ControllerInterface, ContainerInjectionInterface {

  protected TemplateFactoryInterface $template_factory;

  protected MessengerInterface $messenger;

  public function __construct(TemplateFactoryInterface $template_factory, MessengerInterface $messenger) {
    $this->templateFactory = $template_factory;
    $this->messenger = $messenger;
  }

  public static function create(ContainerInterface $container) {
    return new static($container
      ->get('template_factory'), $container
      ->get('messenger'));
  }

  protected function template(string $name): TemplateFacadeInterface {
    return $this->templateFactory->load($name);
  }

  protected function render(string $name, array $variables): string {
    $template = $this->template($name);

    foreach ($variables as $name => $value) {
      $template->set($name, $value);
    }

    return $template->render();
  }

}
