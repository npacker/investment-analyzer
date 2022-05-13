<?php

namespace App\Container;

interface ServiceDefinitionInterface {

  public function name();

  public function class();

  public function arguments();

  public function shared();

}
