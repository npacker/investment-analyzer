<?php

namespace App\Controller;

use App\Container\ContainerInjectionInterface;
use App\Container\ContainerInterface;
use App\Controller\AbstractController;
use App\Controller\ControllerInterface;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use Twig\Environment as TwigEnvironment;

final class NotFoundController implements ControllerInterface, ContainerInjectionInterface {

  private TwigEnvironment $twig;

  public function __construct(TwigEnvironment $twig) {
    $this->twig = $twig;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('twig'));
  }

  public function view(RequestInterface $request) {
    return new HttpResponse($this->twig->render('404', [
      'title' => 'Not Found',
    ]), HttpResponse::HTTP_NOT_FOUND);
  }

}
