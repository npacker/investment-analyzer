<?php

namespace App\Router;

use App\PatternMatching\EscapedInterface;

final class EscapedRoutePath implements EscapedInterface {

  private string $path;

  private string $delimiter;

  public function __construct(string $path, string $delimiter = '@') {
    $this->path = $path;
    $this->delimiter = $delimiter;
  }

  public function __toString(): string {
    $pattern = $this->delimiter . '(['. preg_quote('=-+?!$*:<>') . '])' . $this->delimiter;
    $replacement = preg_quote('\\') . '$1';

    return preg_replace($pattern, $replacement, $this->path);
  }

  public function raw(): string {
    return $this->path;
  }

}
