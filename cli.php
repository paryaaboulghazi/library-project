<?php

use Src\Commands\CreateRepositoryCommand;
use Src\Commands\DeleteRepositoryCommand;
use Src\Core\Config;

require __DIR__ . '/vendor/autoload.php';
$container = require __DIR__ . '/bootstrap.php';

$command = $argv[1] ?? null;


switch ($command) {
    case 'create-repo':
        $createRepoCommand = $container->resolve(CreateRepositoryCommand::class);
        $createRepoCommand->execute();
        break;
    case 'delete-repo':
        $deleteRepoCommand = $container->resolve(DeleteRepositoryCommand::class);
        $deleteRepoCommand->execute();
        break;
    default:
        echo "Available commands: create-repo, delete-repo\n";
}
