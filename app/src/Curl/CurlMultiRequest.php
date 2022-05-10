<?php

namespace App/Curl;

class CurlMultiRequest {

  private $handle;

  private $requests;

  public function __construct(CurlSubRequest ...$requests) {
    $this->handle = curl_multi_init();
    $this->requests = $requests;

    curl_multi_setopt($this->handle, CURLMOPT_PIPELINING, 0);
    curl_multi_setopt($this->handle, CURLMOPT_MAX_HOST_CONNECTIONS, 1);

    foreach ($this->requests as $request) {
      curl_multi_add_handle($this->handle, $request->handle());
    }
  }

  public function __destruct() {
    curl_multi_close($this->handle);
  }

  public function execute() {
    $results = [];

    do {
      $status = curl_multi_exec($this->handle, $running);

      if ($running) {
        curl_multi_select($this->handle);
      }
    } while ($running && $status === CURLM_OK);

    foreach ($this->requests as $request) {
      $buffer = curl_multi_getcontent($request->handle());
      $result = $request->parse($buffer);
      $results = array_merge($results, $result);

      curl_multi_remove_handle($this->handle, $request->handle());
    }

    return $results;
  }

}
