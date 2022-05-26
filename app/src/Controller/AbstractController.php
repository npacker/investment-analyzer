<?php

namespace App\Controller;

use App\App;
use App\Container\ContainerInjectionInterface;
use App\Container\ContainerInterface;
use App\Controller\ControllerInterface;
use App\Http\ResponseInterface;
use App\Http\HttpResponse;
use App\Messenger\MessengerInterface;
use App\Render\TemplateFacadeInterface;
use App\Render\TemplateFactoryInterface;
use App\Router\RouteMatchInterface;
use App\UrlFactory;

abstract class AbstractController implements ControllerInterface, ContainerInjectionInterface {

  protected TemplateFactoryInterface $template_factory;

  protected MessengerInterface $messenger;

  protected RouteMatchInterface $routeMatch;

  final public function __construct(TemplateFactoryInterface $template_factory, MessengerInterface $messenger, RouteMatchInterface $route_match, UrlFactory $url_factory) {
    $this->templateFactory = $template_factory;
    $this->messenger = $messenger;
    $this->routeMatch = $route_match;
    $this->urlFactory = $url_factory;
  }

  public static function create(ContainerInterface $container) {
    return new static($container
      ->get('template_factory'), $container
      ->get('messenger'), $container
      ->get('route_match'), $container
      ->get('url_factory'));
  }

  final protected function template(string $name): TemplateFacadeInterface {
    return $this->templateFactory->load($name);
  }

  final protected function render(string $name, array $variables): string {
    $template = $this->template($name);

    foreach ($variables as $name => $value) {
      $template->set($name, $value);
    }

    return $template->render();
  }

  final protected function url(string $name): string {
    return $this->urlFactory->urlFromRoute($name);
  }

  final protected function redirect(string $url): ResponseInterface {
    return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => $url]);
  }

}
