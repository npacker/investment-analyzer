<?php

namespace App;

use App\Container\ContainerInterface;
use App\Context;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\Twig\RuntimeTwigExtension;
use App\Router\RequestMatchingInterface;
use App\Router\RouteNotFoundException;
use App\Settings;
use App\UrlFactory;

final class App {

  private $autoloader;

  private ContainerInterface $container;

  private Settings $settings;

  private RequestMatchingInterface $routes;

  private RequestInterface $request;

  public function __construct($autoloader, ContainerInterface $container, Settings $settings, RequestMatchingInterface $routes) {
    $this->autoloader = $autoloader;
    $this->container = $container;
    $this->settings = $settings;
    $this->routes = $routes;
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
    $twig = $this->container->get('twig');
    $context = new Context($this, $request);
    $url_factory = new UrlFactory($context);

    $twig->addExtension(new RunTimeTwigExtension($context, $url_factory));

    try {
      $match = $this->routes->match($request);
      $route = $match->route();
      $controller = $route->controller();
      $action = $route->action();

      $this->container->set('route_match', $match);
      $this->container->set('url_factory', $url_factory);
      $this->initializeDatabase();
    }
    catch (RouteNotFoundException $e) {
      $controller = 'App\Controller\NotFoundController';
      $action = 'view';
    }

    $instance = $controller::create($this->container);

    return $instance->{$action}($request);
  }

  private function initializeDatabase(): void {
    $database_factory = $this->container->get('database_factory');
    $database = $database_factory->getInstance();

    $this->container->set('database', $database);
  }

}
