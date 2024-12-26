<?php

namespace Src\Models;

use Src\Core\DB;

class Book
{
    /**
     * Retrieve all books.
     */
    public static function all()
    {
        $db = DB::get();

        return $db->query('SELECT * FROM books')->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Find a book by its ID.
     */
    public static function find($id)
    {
        $db = DB::get();
        $stmt = $db->prepare('SELECT * FROM books WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Update a book by its ID.
     */
    public static function update($id, array $data)
    {
        $db = DB::get();
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "`$key` = :$key";
        }

        $query = 'UPDATE books SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Filter books by column and value.
     */
    public static function where($column, $value)
    {
        $db = DB::get();
        $stmt = $db->prepare("SELECT * FROM books WHERE $column = :value");
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Validate the input data.
     */
    public static function validate(array $data)
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = 'Title is required.';
        }

        if (empty($data['author'])) {
            $errors[] = 'Author is required.';
        }

        if (empty($data['published_year']) || !is_numeric($data['published_year'])) {
            $errors[] = 'Published year is required and must be an integer.';
        }

        return $errors;
    }

    /**
     * Store a new book in the database.
     */
    public static function store(array $data)
    {
        $validationErrors = self::validate($data);

        if (!empty($validationErrors)) {
            return ['status' => false, 'message' => implode(' ', $validationErrors)];
        }

        $db = DB::get();
        $query = "INSERT INTO books (title, author, published_year, is_borrowed, created_at, updated_at)
                  VALUES (:title, :author, :published_year, :is_borrowed, :created_at, :updated_at)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindValue(':title', $data['title'], \PDO::PARAM_STR);
            $stmt->bindValue(':author', $data['author'], \PDO::PARAM_STR);
            $stmt->bindValue(':published_year', $data['published_year'], \PDO::PARAM_INT);
            $stmt->bindValue(':is_borrowed', $data['is_borrowed'] ?? false, \PDO::PARAM_BOOL);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'The book has been successfully added.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to insert the book: ' . $stmt->errorInfo()[2]
                ];
            }
        } catch (\PDOException $e) {
            return [
                'status' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}
