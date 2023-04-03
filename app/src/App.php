<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\Twig\RuntimeTwigExtension;
use App\Router\RequestMatchingInterface;
use App\Router\RouteNotFoundException;
use App\Settings;

final class App implements AppInterface {

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

    $this->initializeTwig();

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

    return $instance->{$action}($request);
  }

  private function initializeTwig(): void {
    $request = $this->container->get('request');
    $url_factory = $this->container->get('url_factory');
    $twig = $this->container->get('twig');

    $twig->addExtension(new RunTimeTwigExtension($this->settings, $request, $url_factory));
  }

}
