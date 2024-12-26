<?php

namespace Src\Core;

use PDO;

class DB
{
    private static $db;

    public static function get(): PDO
    {
        if (!is_null(self::$db)) {
            return self::$db;
        }

        $db = new PDO(
            'mysql:host=' . Config::get('db.host') . ';dbname=' . Config::get('db.database'),
            Config::get('db.username'),
            Config::get('db.password')
        );

//        $db = new PDO(
//            'mysql:host=localhost' . ';dbname=library-project',
//            'library-project',
//            '12345678'
//        );
        self::$db = $db;
        return $db;
    }
}
