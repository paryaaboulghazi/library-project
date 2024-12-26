<?php

namespace Src\Http\Controllers;
use Src\Core\View;
use Src\Models\Book;

class BookController
{
    public function index()
    {
        $books = Book::all();

        echo  View::render('books-index', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        echo  View::render('books-create');
    }

    public function store()
    {
        $requestParams = $_POST;

        Book::store($requestParams);

        header('Location: /books');

        exit;
    }
}