<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/DatabaseConnection.php';
if (isset($_GET['query'])) {
    $like = $_GET['query'];
    $pdo = \DatabaseConnection::connect();
    $query = $pdo->prepare('SELECT name FROM CATEGORY WHERE name LIKE :like ORDER BY name LIMIT 10');
    $query->bindValue(':like','%'.$like.'%');
    $query->execute();

    $suggestions ='';
    while ($result = $query->fetch(PDO::FETCH_ASSOC)){
        $suggestions .= '<li>'.$result['name'].'</li>';
    }
    echo $suggestions;
}

