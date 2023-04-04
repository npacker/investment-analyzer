<?php

namespace App\Controller;

use App\Container\ContainerInjectionInterface;
use App\Container\ContainerInterface;
use App\Http\HttpResponse;
use App\Http\ResponseInterface;
use App\Messenger\MessengerInterface;
use App\Render\TemplateFacadeInterface;
use App\Render\TemplateFactoryInterface;
use App\UrlFactory;

abstract class AbstractController implements ContainerInjectionInterface {

  protected TemplateFactoryInterface $template_factory;

  protected MessengerInterface $messenger;

  protected UrlFactory $urlFactory;

  final public function __construct(TemplateFactoryInterface $template_factory, MessengerInterface $messenger, UrlFactory $url_factory) {
    $this->templateFactory = $template_factory;
    $this->messenger = $messenger;
    $this->urlFactory = $url_factory;
  }

  public static function create(ContainerInterface $container) {
    return new static($container
      ->get('template_factory'), $container
      ->get('messenger'), $container
      ->get('url_factory'));
  }

  final protected function template(string $name): TemplateFacadeInterface {
    return $this->templateFactory->load($name);
  }

  final protected function render(string $name, array $variables = []): string {
    $template = $this->template($name);

    foreach ($variables as $name => $value) {
      $template->set($name, $value);
    }

    return $template->render();
  }

  final protected function url(string $name): string {
    return $this->urlFactory->urlFromRoute($name);
  }

  final protected function response(string $name, array $variables = []): ResponseInterface {
    return new HttpResponse($this->render($name, $variables));
  }

  final protected function redirect(string $url): ResponseInterface {
    return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => $url]);
  }

}
