<?php

namespace App;

use App\Context;
use App\Http\RequestInterface;
use App\Router\RouteCollection;

final class UrlFactory {

  private RequestInterface $request;

  private RouteCollection $routes;

  public function __construct(Context $context) {
    $this->request = $context->request();
    $this->routes = $context->routes();
  }

  public function urlFromRoute(string $name, array $parameters = []): string {
    $route = $this->routes->get($name);

    return $this->urlFromPath($route->path(), $parameters);
  }

  public function urlFromPath(string $path, array $parameters = []): string {
    $query = http_build_query($parameters);
    $url = $this->baseUrl() . $path;

    return ($query) ? $url . '?' . $query : $url;
  }

  public function baseUrl(): string {
    static $base_url;

    if (!isset($base_url)) {
      $scheme = $this->request->server('REQUEST_SCHEME');
      $host = $this->request->server('HTTP_HOST');
      $base_url = $scheme . '://' . $host;
    }

    return $base_url;
  }

}
