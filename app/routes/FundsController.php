<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\RouteController;
use App\Http\RequestInterface;
use App\Model\Storage\FundPositionStorageInterface;
use App\Model\Storage\FundStorageInterface;
use App\Model\Storage\SecurityStorageInterface;
use App\Stream\FileLinesAsCsv;

final class FundsController extends RouteController {

  private FundStorageInterface $fundStorage;

  private SecurityStorageInterface $securityStorage;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setFundStorage($container->get('fund_storage'));
    $instance->setSecurityStorage($container->get('security_storage'));
    $instance->setFundPositionStorage($container->get('fund_position_storage'));

    return $instance;
  }

  public function setFundStorage(FundStorageInterface $fund_storage) {
    $this->fundStorage = $fund_storage;
  }

  public function setSecurityStorage(SecurityStorageInterface $security_storage) {
    $this->securityStorage = $security_storage;
  }

  public function setFundPositionStorage(FundPositionStorageInterface $fund_position_storage) {
    $this->fundPositionStorage = $fund_position_storage;
  }

  public function view(RequestInterface $request) {
    $symbol = $this->routeMatch->parameters('symbol');

    try {
      $positions = $this->fundPositionStorage->find($symbol);
    }
    catch (\Exception $e) {
      $this->messenger->setError($e->getMessage());
    }

    try {
      $fund = $this->fundStorage->find($symbol);
      $name = $fund['name'];
    }
    catch (\Exception $e) {
      $this->messenger->setError($e->getMessage());
    }

    return $this->response('funds/view', [
      'symbol' => $symbol,
      'name' => $name,
      'positions' => $positions,
    ]);
  }

  public function viewAll(RequestInterface $request) {
    $funds = $this->fundStorage->all();

    return $this->response('funds', [
      'funds' => $funds,
    ]);
  }

  public function createView(RequestInterface $request) {
    return $this->response('funds/create');
  }

  public function createSubmit(RequestInterface $request) {
    $symbol = $request->post('symbol');
    $name = $request->post('name');

    try {
      $this->fundStorage->create($symbol, $name);
      $this->messenger->set(sprintf("Created new fund <strong>%s</strong>.", $name));
    }
    catch (\Exception $e) {
      $this->messenger->setError($e->getMessage());
    }

    return $this->redirect($this->url('funds_create_view'));
  }

  public function editView(RequestInterface $request) {
    $symbol = $this->routeMatch->parameters('symbol');
    $fund = $this->fundStorage->find($symbol);
    $name = $fund['name'];

    return $this->response('funds/edit', [
      'name' => $name,
      'symbol' => $symbol,
    ]);
  }

  public function editSubmit(RequestInterface $request) {
    $symbol = $this->routeMatch->parameters('symbol');
    $name = $request->post('name');

    if ($request->post('replace_positions')) {
      try {
        $this->fundPositionStorage->deleteByFund($symbol);
      }
      catch (\Exception $e) {
        $this->messenger->setError($e->getMessage());
      }
    }

    try {
      $this->fundStorage->update($symbol, $name);
      $this->messenger->set(sprintf("Updated fund <strong>%s</strong>.", $name));
    }
    catch (\Exception $e) {
      $this->messenger->setError($e->getMessage());
    }

    $positions = $request->files('positions');
    $file = new FileLinesAsCsv($positions['tmp_name']);

    foreach ($file as $line) {
      if (empty(trim($line['Security']))) {
        continue;
      }

      try {
        $this->securityStorage->create($line['Security'], $line['Name']);
        $this->fundPositionStorage->create($symbol, $line['Security'], $line['Weight']);
      }
      catch (\Exception $e) {
        $this->messenger->setError(sprintf("Error while adding position %s: ", $line['Security']) . $e->getMessage());
      }
    }

    return $this->redirect($this->url('funds_view_all'));
  }

  public function deleteConfirm(RequestInterface $request) {
    return $this->redirect($this->url('funds_view_all'));
  }

  public function deleteSubmit(RequestInterface $request) {
    return $this->redirect($this->url('funds_view_all'));
  }

}
