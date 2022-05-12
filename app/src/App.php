<?php

namespace App;

use App\Context;
use App\Http\Request;
use App\Router\RouteCollection;
use App\Router\RouteNotFoundException;
use App\Settings;

final class App {

  private $autoloader;

  private $settings;

  private $routes;

  private $request;

  private $twig;

  public function __construct($autoloader, Settings $settings, RouteCollection $routes, \Twig\Environment $twig) {
    $this->autoloader = $autoloader;
    $this->settings = $settings;
    $this->routes = $routes;
    $this->twig = $twig;
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

  public function handle(Request $request) {
    $context = new Context($request, $this);

    $this->twig->addGlobal('app', $context);

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
