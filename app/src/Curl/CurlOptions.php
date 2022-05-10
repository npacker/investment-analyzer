<?php

class CurlOptions {

  private $cainfo;

  public function __construct(string $cainfo) {
    $this->cainfo = $cainfo;
  }

  public function apply($handle) {
    curl_setopt($handle, CURLOPT_HTTPHEADER, [
      'Cache-Control: no-store',
      'Pragma: no-cache',
    ]);
    curl_setopt($handle, CURLOPT_FRESH_CONNECT, TRUE);
    curl_setopt($handle, CURLOPT_FORBID_REUSE, TRUE);
    curl_setopt($handle, CURLOPT_ENCODING, '');
    curl_setopt($handle, CURLOPT_HEADER, FALSE);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($handle, CURLOPT_CAINFO, $this->cainfo);
  }

}
