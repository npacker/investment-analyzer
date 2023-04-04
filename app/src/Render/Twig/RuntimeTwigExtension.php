<?php

namespace App\Render\Twig;

use App\Http\RequestInterface;
use App\UrlFactory;
use Twig\Extension\AbstractExtension as TwigAbstractExtension;
use Twig\Extension\GlobalsInterface as TwigGlobalsInterface;
use Twig\TwigFunction;

final class RuntimeTwigExtension extends TwigAbstractExtension implements TwigGlobalsInterface {

  private RequestInterface $request;

  private UrlFactory $urlFactory;

  public function __construct(RequestInterface $request, UrlFactory $url_factory) {
    $this->request = $request;
    $this->urlFactory = $url_factory;
  }

  public function getGlobals(): array {
    return [
      'request' => $this->request,
    ];
  }

  public function getFunctions(): array {
    return [
      new TwigFunction('url', [$this->urlFactory, 'urlFromRoute']),
      new TwigFunction('urlFromPath', [$this->urlFactory, 'urlFromPath']),
      new TwigFunction('baseUrl', [$this->urlFactory, 'baseUrl']),
    ];
  }

}
