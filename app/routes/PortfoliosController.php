<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use App\Storage\PortfolioStorageInterface;

final class PortfoliosController extends AbstractController {

  private PortfolioStorageInterface $portfolioStorage;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setPortfolioStorage($container->get('portfolio_storage'));

    return $instance;
  }

  public function setPortfolioStorage(PortfolioStorageInterface $portfolio_storage) {
    $this->portfolioStorage = $portfolio_storage;
  }

  public function view(RequestInterface $request) {
    $portfolios = $this->portfolioStorage->all();

    return new HttpResponse($this->render('portfolios.html.twig', [
      'title' => 'Portfolios',
      'portfolios' => $portfolios,
    ]));
  }

  public function createView(RequestInterface $request) {
    return new HttpResponse($this->render('portfolios/create.html.twig', [
      'title' => 'Create Portfolio',
    ]));
  }

  public function createSubmit(RequestInterface $request) {
    $name = $request->post('name');

    try {
      $this->portfolioStorage->create($name);
      $this->messenger->set(sprintf("Created new portfolio <strong>%s</strong>.", $name));
    }
    catch (\Exception $e) {
      $this->messenger->setError($e->getMessage());
    }

    return $this->redirect($this->url('portfolios_view_all'));
  }

}
