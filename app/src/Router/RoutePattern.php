<?php

namespace App\Router;

use App\PatternMatching\EscapedInterface;

final class RoutePattern implements RoutePatternInterface {

  private $path;

  private $delimiter;

  public function __construct(EscapedInterface $path, string $delimiter = '@') {
    $this->path = $path;
    $this->delimiter = $delimiter;
  }

  public function __toString() {
    $pattern = $this->delimiter . '{[^/]+}' . $this->delimiter;
    $replacement = '([^/]+)';

    return $this->delimiter . '^' . preg_replace($pattern, $replacement, $this->path) . '$' . $this->delimiter;
  }

  public function raw() {
    return $this->path->raw();
  }

  public function labels() {
    preg_match_all($this->delimiter . '{([^\/]+)}' . $this->delimiter, $this->path->raw(), $labels);

    return array_values(end(array_slice($labels, 1)));
  }

}
