<?php

namespace App\Container;

use App\Container\ServiceDefinitionInterface;
use App\Container\ServiceArgumentDefinition;
use App\Container\ParameterArgumentDefinition;

final class ServiceDefinition implements ServiceDefinitionInterface {

  private string $name;

  private string $class;

  private array $arguments;

  private bool $shared;

  public function __construct(string $name, array $definition) {
    $this->name = $name;
    $this->class = $definition['class'];
    $this->arguments = $definition['arguments'] ?? [];
    $this->shared = $definition['shared'] ?? true;
  }

  public function name(): string {
    return $this->name;
  }

  public function class(): string {
    return $this->class;
  }

  public function arguments(): array {
    $definition = [];

    foreach ($this->arguments as $argument) {
      $is_service = (bool) preg_match('/^@(.+)$/', $argument, $service);
      $is_parameter = (bool) preg_match('/^%(.+)%$/', $argument, $parameter);

      if ($is_service) {
        $name = $service[1];
        $definition[$name] = new ServiceArgumentDefinition($name);
      }

      if ($is_parameter) {
        $name = $parameter[1];
        $definition[$name] = new ParameterArgumentDefinition($name);
      }
    }

    return $definition;
  }

  public function shared(): bool {
    return $this->shared;
  }

}
