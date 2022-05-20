<?php

namespace App;

use App\Environment;
use App\Http\HttpRequest;

$autoloader = require 'autoload.php';
$environment = new Environment($autoloader);
$app = $environment->bootstrap();
$request = new HttpRequest();
$response = $environment->install($request, $app);
$response->send();
