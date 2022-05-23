<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use App\Storage\SecurityStorageInterface;

final class SecuritiesController extends AbstractController {

  private SecurityStorageInterface $securityStorage;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setSecurityStorage($container->get('security_storage'));

    return $instance;
  }

  public function setSecurityStorage(SecurityStorageInterface $security_storage) {
    $this->securityStorage = $security_storage;
  }

  public function view(RequestInterface $request) {
    $securities = $this->securityStorage->all();

    return new HttpResponse($this->render('securities.html.twig', [
      'title' => 'Securities',
      'securities' => $securities,
    ]));
  }

}
