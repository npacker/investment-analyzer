<?php

namespace App\Controller;

use App\App;
use App\Container\ContainerInterface;
use App\Controller\ControllerInterface;
use App\Render\TemplateFacadeInterface;

abstract class AbstractController implements ControllerInterface {

  protected ContainerInterface $container;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  protected function template(string $name): TemplateFacadeInterface {
    $factory = $this->container->get('template_factory');

    return $factory->load($name);
  }

  protected function render(string $name, array $variables): string {
    $template = $this->template($name);

    foreach ($variables as $name => $value) {
      $template->set($name, $value);
    }

    return $template->render();
  }

}
