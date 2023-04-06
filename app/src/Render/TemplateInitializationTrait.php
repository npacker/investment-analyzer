<?php

namespace App\Render;

use App\Container\ContainerInterface;

trait TemplateInitializationTrait {

  abstract public function container(): ContainerInterface;

  private function initializeTemplateEngine(): void {
    $template_engine_builder = $this->container()->get('template_engine_runtime_builder');

    $template_engine_builder->build();
  }

}
