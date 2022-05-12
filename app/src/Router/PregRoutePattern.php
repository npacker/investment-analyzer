<?php

namespace App\Router;

final class PregRoutePattern {

  private $path;

  private $delimiter;

  public function __construct(string $path, string $delimiter = '@') {
    $this->path = $path;
    $this->delimiter = $delimiter;
  }

  public function __toString() {
    $pattern = $this->delimiter . '{[^/]+}' . $this->delimiter;
    $replacement = '([^/]+)';
    $escaped = (string) new PregRouteEscaped($this->path, $this->delimiter);

    return $this->delimiter . '^' . preg_replace($pattern, $replacement, $escaped) . '$' . $this->delimiter;
  }

}
