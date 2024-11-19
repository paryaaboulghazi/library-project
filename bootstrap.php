<?php

use Dotenv\Dotenv;
use Src\Core\Config;
use Src\Core\Container;
use Src\Services\GitHubApiService;
use Src\Services\VCSApiInterface;

if (isset($container)) {
    return $container;
}

$container = new Container();

$container->bind(VCSApiInterface::class, function () {
    return new GitHubApiService();
});

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
Config::loadConfig();

return $container;
