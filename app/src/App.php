<?php

namespace App;

use App\Container\ContainerInterface;
use App\Context;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Router\RequestMatchingInterface;
use App\Router\RouteNotFoundException;
use App\Settings;
use Twig\Environment as TwigEnvironment;

final class App {

  private $autoloader;

  private ContainerInterface $container;

  private Settings $settings;

  private RequestMatchingInterface $routes;

  private RequestInterface $request;

  private TwigEnvironment $twig;

  public function __construct($autoloader, ContainerInterface $container, Settings $settings, RequestMatchingInterface $routes, TwigEnvironment $twig) {
    $this->autoloader = $autoloader;
    $this->container = $container;
    $this->settings = $settings;
    $this->routes = $routes;
    $this->twig = $twig;
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

  public function twig(): TwigEnvironment {
    return $this->twig;
  }

  public function handle(RequestInterface $request): ResponseInterface {
    $context = new Context($request, $this);

    $this->twig->addGlobal('app', $context);

    $messenger = $this->container->get('messenger');

    $this->twig->addGlobal('messenger', $messenger);

    $database_factory = $this->container->get('database_factory');
    $database = $database_factory->getInstance();

    $this->container->set('database', $database);

    try {
      $match = $this->routes->match($request);

      $this->container->set('route_match', $match);

      $route = $match->route();
      $controller = $route->controller();
      $action = $route->action();
    }
    catch (RouteNotFoundException $e) {
      $controller = '\App\Controller\NotFoundController';
      $action = 'view';
    }

    $instance = new $controller($this);

    return $instance->{$action}($request);
  }

}
