<?php

namespace App;

use Src\Core\Router;
use Src\Http\Controllers\BookController;
use Src\Http\Controllers\LoanController;
use Src\Http\Controllers\MemberController;

Router::get('/', [MemberController::class, 'index']);

Router::get('/books', [BookController::class, 'index']);
Router::post('/books', [BookController::class, 'store']);
Router::get('/books/create', [BookController::class, 'create']);

Router::get('/members', [MemberController::class, 'index']);
Router::post('/members', [MemberController::class, 'store']);
Router::get('/members/create', [MemberController::class, 'create']);



Router::post('/loans/{loan}/return', [LoanController::class, 'return']);
Router::get('/loans', [LoanController::class, 'index']);
Router::post('/loans', [LoanController::class, 'store']);
Router::get('/loans/create', [LoanController::class, 'create']);
