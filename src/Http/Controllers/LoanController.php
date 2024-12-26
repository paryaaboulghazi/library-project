<?php

namespace Src\Http\Controllers;
use Src\Core\View;
use Src\Models\Book;
use Src\Models\Loan;
use Src\Models\Member;

class LoanController
{
    public function index()
    {
        $loans = Loan::all();

        echo  View::render('loans-index', [
            'loans' => $loans,
        ]);
    }

    public function create()
    {
        $members = Member::all();
        $books = Book::where('is_borrowed', false);

        echo  View::render('loans-create', [
            'members' => $members,
            'books' => $books,
        ]);
    }

    public function store()
    {
        $requestParams = $_POST;

        $book = Book::find($requestParams['book_id']);

        if ($book['is_borrowed']) {
            return "Book is not available";
        }

        $now = new \DateTime();
        $now->modify('+7 days');
        $dueDate = $now->format('Y-m-d H:i:s');

        Loan::store(array_merge($requestParams, ['due_date' => $dueDate]));
        Book::update($book['id'] ,['is_borrowed' => true]);

        header('Location: /loans');

        exit;
    }


    public function return($loanId)
    {
        $loan = Loan::find($loanId);


        if ($loan['is_returned']) {
            return 'This book has already been returned.';
        }

        Loan::update($loan['id'], ['is_returned' => 1]);

        $book = Book::find($loan['book_id']);
        Book::update($loan['book_id'], ['is_borrowed' => 0]);

        header('Location: /loans');

        exit;
    }
}