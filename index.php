<?php

use Src\Core\Router;
use OpenApi\Generator;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';
include __DIR__ . '/src/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

Router::dispatch($requestUri);
