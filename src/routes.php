<?php

namespace App;

use Src\Core\Router;
use Src\Http\Controllers\RepositoryController;

Router::get('/repos', [RepositoryController::class, 'index']);
