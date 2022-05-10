<?php

$options = new CurlOptions($settings['cainfo']);
$requests = [];

foreach ($settings['endpoints'] as $endpoint) {
  $url = $endpoint['url'];
  $type = $endpoint['type'];
  $parser = new $type($url);
  $requests[] = new CurlSubRequest($url, $options, $parser);
}

$multi = new CurlMultiRequest(...$requests);
$results = $multi->execute();
$json = json_encode($results);

header('Content-Type: application/json');

echo $json;
