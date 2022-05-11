<?php

namespace App;

use App\Context;
use App\Settings;
use App\Http\Request;

final class App {

  private $autoloader;

  private $settings;

  private $request;

  private $twig;

  public function __construct($autoloader, Settings $settings, \Twig\Environment $twig) {
    $this->autoloader = $autoloader;
    $this->settings = $settings;
    $this->twig = $twig;
  }

  public function settings() {
    return $this->settings;
  }

  public function twig() {
    return $this->twig;
  }

  public function handle(Request $request) {
    $context = new Context($request, $this->settings);

    $this->twig->addGlobal('app', $context);

    switch ($request->path()) {

      case '/':
        $controller = new \App\Route\MainController($this);
        break;

      case '/portfolios':
        $controller = new \App\Route\PortfoliosController($this);
        break;

      case '/portfolios/create':
        $controller = new \App\Route\PortfoliosCreateController($this);
        break;

      case '/funds':
        $controller = new \App\Route\FundsController($this);
        break;

      case '/funds/create':
        $controller = new \App\Route\FundsCreateController($this);
        break;

      case '/securities':
        $controller = new \App\Route\SecuritiesController($this);
        break;

      case '/overlap':
        $controller = new \App\Route\OverlapController($this);
        break;

      default:
        $controller = new \App\Route\NotFoundController($this);
        break;

    }

    return $controller->handle($request);
  }

}
