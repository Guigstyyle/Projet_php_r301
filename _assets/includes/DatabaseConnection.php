<?php

class DatabaseConnection
{
    public static function connect(): PDO
    {

        $dsn = 'mysql:host=mysql-wang-m.alwaysdata.net;dbname=wang-m_forum';
        $pdo = new PDO($dsn, 'wang-m_forumdb', 'passdbwang');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    }
}
