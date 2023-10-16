<?php

class DatabaseConnection
{
    public static function connect(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=forum';
        return new PDO($dsn,'forumDB','pass');
    }
}