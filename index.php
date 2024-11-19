<?php

use Src\Core\Router;
use OpenApi\Generator;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';
include __DIR__ . '/src/routes.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/docs') {
    $openapi = Generator::scan([__DIR__ . '/src']);
    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
    exit();
}


Router::dispatch($requestUri);
