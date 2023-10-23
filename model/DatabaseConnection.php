<?php

class DatabaseConnection
{
    public static function connect(): PDO
    {

        $dsn = 'mysql:host=localhost;dbname=forum';
        $pdo = new PDO($dsn,'forumDB','pass');
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;

    }
}