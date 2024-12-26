<?php

namespace Src\Models;

use Src\Core\DB;

class Member
{
    /**
     * Retrieve all members.
     */
    public static function all()
    {
        $db = DB::get();
        
        return $db->query('SELECT * FROM members')->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Validate the input data.
     */
    public static function validate(array $data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        }

        if (empty($data['phone']) || !is_numeric($data['phone'])) {
            $errors[] = 'Phone is required and must be an integer.';
        }

        return $errors;
    }

    /**
     * Store a new member in the database.
     */
    public static function store(array $data)
    {
        $validationErrors = self::validate($data);

        if (!empty($validationErrors)) {
            return ['status' => false, 'message' => implode(' ', $validationErrors)];
        }

        $db = DB::get();
        $query = "INSERT INTO members (name, email, phone, created_at, updated_at)
                  VALUES (:name, :email, :phone, :created_at, :updated_at)";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindValue(':name', $data['name'], \PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], \PDO::PARAM_STR);
            $stmt->bindValue(':phone', $data['phone'], \PDO::PARAM_INT);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), \PDO::PARAM_STR);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'The member has been successfully added.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to insert the member: ' . $stmt->errorInfo()[2]
                ];
            }
        } catch (\PDOException $e) {
            return [
                'status' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
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
}
