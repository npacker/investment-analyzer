<?php

namespace App;

use App\Container\ContainerInterface;
use App\Context;
use App\Http\RequestInterface;
use App\Router\RequestMatchingInterface;
use App\Router\RouteNotFoundException;
use App\Settings;
use Twig\Environment as TwigEnvironment;

final class App {

  private $autoloader;

  private $container;

  private $settings;

  private $routes;

  private $request;

  private $twig;

  public function __construct($autoloader, ContainerInterface $container, Settings $settings, RequestMatchingInterface $routes, TwigEnvironment $twig) {
    $this->autoloader = $autoloader;
    $this->container = $container;
    $this->settings = $settings;
    $this->routes = $routes;
    $this->twig = $twig;
  }

  public function container() {
    return $this->container;
  }

  public function settings() {
    return $this->settings;
  }

  public function routes() {
    return $this->routes;
  }

  public function twig() {
    return $this->twig;
  }

  public function handle(RequestInterface $request) {
    $context = new Context($request, $this);

    $this->twig->addGlobal('app', $context);

    $factory = $this->container->get('database_factory');

    $this->container->set('database', $factory->getInstance());

    try {
      $match = $this->routes->match($request);
      $controller = $match->route()->controller();
      $action = $match->route()->action();
    }
    catch (RouteNotFoundException $e) {
      $controller = '\App\Controller\NotFoundController';
      $action = 'view';
    }

    $instance = new $controller($this);

    return $instance->{$action}($request);
  }

}
