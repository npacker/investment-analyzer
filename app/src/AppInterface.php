<?php

namespace App;

use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Router\RequestMatchingInterface;
use App\Settings;

interface AppInterface {

  public function autoloader();

  public function container(): ContainerInterface;

  public function settings(): Settings;

  public function routes(): RequestMatchingInterface;

  public function handle(RequestInterface $request): ResponseInterface;

}
