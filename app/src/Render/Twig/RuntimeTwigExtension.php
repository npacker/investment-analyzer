<?php

namespace App\Render\Twig;

use App\Http\RequestInterface;
use App\Settings;
use App\UrlFactory;
use Twig\Extension\AbstractExtension as TwigAbstractExtension;
use Twig\Extension\GlobalsInterface as TwigGlobalsInterface;
use Twig\TwigFunction;

final class RuntimeTwigExtension extends TwigAbstractExtension implements TwigGlobalsInterface {

  private Settings $settings;

  private RequestInterface $request;

  private UrlFactory $urlFactory;

  public function __construct(Settings $settings, RequestInterface $request, UrlFactory $url_factory) {
    $this->settings = $settings;
    $this->request = $request;
    $this->urlFactory = $url_factory;
  }

  public function getGlobals(): array {
    return [
      'settings' => $this->settings,
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
