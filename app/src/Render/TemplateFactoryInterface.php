<?php

namespace App\Render;

use App\Render\TemplateFacadeInterface;

interface TemplateFactoryInterface {

  public function load(string $name): TemplateFacadeInterface;

}
