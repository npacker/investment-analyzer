<?php

namespace App;

use App\Environment;
use App\Http\HttpRequest;

$autoloader = require '/../autoload.php';
$environment = new Environment($autoloader);
$response = $environment->install();
$response->send();
