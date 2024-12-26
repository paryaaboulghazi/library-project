<?php

use Dotenv\Dotenv;
use Src\Core\Config;
use Src\Core\Container;

if (isset($container)) {
    return $container;
}

$container = new Container();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
Config::loadConfig();

return $container;
