<?php

namespace App\Render;

trait TemplateInitializationTrait {

  private function initializeTemplateEngine(): void {
    $template_engine_builder = $this->container()->get('template_engine_runtime_builder');

    $template_engine_builder->build();
  }

}
