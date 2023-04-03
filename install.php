<?php

namespace App;

use App\Environment;
use App\Http\HttpRequest;
use App\InstallEnvironment;

$autoloader = require 'autoload.php';
$environment = new InstallEnvironment(new Environment($autoloader));
$app = $environment->bootstrap();
$request = new HttpRequest();
$response = $app->handle($request);
$response->send();
