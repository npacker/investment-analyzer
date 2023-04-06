<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\RouteController;
use App\Http\RequestInterface;
use App\Model\Storage\FundStorageInterface;
use App\Model\Storage\PortfolioStorageInterface;

final class PortfoliosController extends RouteController {

  private FundStorageInterface $fundStorage;

  private PortfolioStorageInterface $portfolioStorage;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setFundStorage($container->get('fund_storage'));
    $instance->setPortfolioStorage($container->get('portfolio_storage'));

    return $instance;
  }

  public function setFundStorage(FundStorageInterface $fund_storage) {
    $this->fundStorage = $fund_storage;
  }

  public function setPortfolioStorage(PortfolioStorageInterface $portfolio_storage) {
    $this->portfolioStorage = $portfolio_storage;
  }

  public function viewAll(RequestInterface $request) {
    $portfolios = $this->portfolioStorage->all();

    return $this->response('portfolios', [
      'portfolios' => $portfolios,
    ]);
  }

  public function createView(RequestInterface $request) {
    return $this->response('portfolios/create');
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

  public function editView(RequestInterface $request) {
    $id = $this->routeMatch->parameters('id');
    $portfolio = $this->portfolioStorage->find($id);
    $name = $portfolio['name'];
    $funds = $this->fundStorage->all();

    return $this->response('portfolios/edit', [
      'name' => $name,
      'funds' => $funds,
    ]);
  }

}
