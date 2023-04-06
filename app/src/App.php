<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\TemplateInitializationTrait;
use App\Router\RequestMatchingInterface;
use App\Router\RouteNotFoundException;
use App\Settings;

final class App implements AppInterface {

  use TemplateInitializationTrait;

  private $autoloader;

  private ContainerInterface $container;

  private Settings $settings;

  private RequestMatchingInterface $routes;

  public function __construct($autoloader, ContainerInterface $container, Settings $settings, RequestMatchingInterface $routes) {
    $this->autoloader = $autoloader;
    $this->container = $container;
    $this->settings = $settings;
    $this->routes = $routes;
  }

  public function autoloader() {
    return $this->autoloader;
  }

  public function container(): ContainerInterface {
    return $this->container;
  }

  public function settings(): Settings {
    return $this->settings;
  }

  public function routes(): RequestMatchingInterface {
    return $this->routes;
  }

  public function handle(RequestInterface $request): ResponseInterface {
    $this->container->set('request', $request);

    try {
      $match = $this->routes->match($request);
      $route = $match->route();
      $controller = $route->controller();
      $action = $route->action();

      $this->container->set('route_match', $match);
    }
    catch (RouteNotFoundException $e) {
      $controller = 'App\Controller\NotFoundController';
      $action = 'view';
    }

    $instance = $controller::create($this->container);

    $this->initializeTemplateEngine();

    return $instance->{$action}($request);
  }

}
