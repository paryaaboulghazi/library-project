<?php

namespace Src\Models;

use Src\Core\DB;

class Loan
{
    /**
     * Retrieve all members.
     */
    public static function all()
    {
        $db = DB::get();
        $query = "
        SELECT loans.*, 
               books.title AS book_title, 
               members.name AS member_name
        FROM loans
        JOIN books ON loans.book_id = books.id
        JOIN members ON loans.member_id = members.id
    ";
        return $db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Find a book by its ID.
     */
    public static function find($id)
    {
        $db = DB::get();
        $stmt = $db->prepare('SELECT * FROM loans WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Store a new member in the database.
     */
    public static function store(array $data)
    {
        $db = DB::get();
        $query = "INSERT INTO loans (book_id, member_id, due_date, created_at, updated_at)
                  VALUES (:book_id, :member_id, :due_date, :created_at, :updated_at)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindValue(':book_id', $data['book_id'], \PDO::PARAM_STR);
            $stmt->bindValue(':member_id', $data['member_id'], \PDO::PARAM_STR);
            $stmt->bindValue(':due_date', $data['due_date'], \PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'The loan has been successfully added.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to insert the loan: ' . $stmt->errorInfo()[2]
                ];
            }
        } catch (\PDOException $e) {
            return [
                'status' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public static function update(int $id, array $data): bool
    {
        $db = DB::get();
        $setClause = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));

        $query = "UPDATE loans SET $setClause WHERE id = :id";
        $statement = $db->prepare($query);

        // Bind parameters
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        return $statement->execute();
    }
}
