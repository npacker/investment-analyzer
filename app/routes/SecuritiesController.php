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
    $symbol = $this->routeMatch->parameters('symbol');
    $security = $this->securityStorage->find($symbol);
    $name = $security['name'];

    return new HttpResponse($this->render('securities/view', [
      'title' => $symbol . ': ' . ucwords(strtolower($name)),
    ]));
  }

  public function viewAll(RequestInterface $request) {
    $securities = $this->securityStorage->all();

    return new HttpResponse($this->render('securities', [
      'title' => 'Securities',
      'securities' => $securities,
    ]));
  }

  public function deleteConfirm(RequestInterface $request) {
    $symbol = $this->routeMatch->parameters('symbol');

    return new HttpResponse($this->render('securities/delete', [
      'title' => 'Delete security ' . $symbol . '?',
    ]));
  }

  public function deleteSubmit(RequestInterface $request) {
    $symbol = $this->routeMatch->parameters('symbol');
    $security = $this->securityStorage->find($symbol);

    $this->securityStorage->delete($symbol);
    $this->messenger->set('Deleted security ' . $symbol . ': ' . $security['name'] . '.');

    return $this->redirect($this->url('securities_view_all'));
  }

}
