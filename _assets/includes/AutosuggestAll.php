<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/DatabaseConnection.php';
if (isset($_GET['query'])) {
    $like = $_GET['query'];
    $pdo = \DatabaseConnection::connect();
    $query = $pdo->prepare('SELECT * FROM CATEGORY WHERE UPPER(name) LIKE UPPER(:like) or UPPER(description) LIKE UPPER(:like) ORDER BY UPPER(name) LIMIT 5');
    $query->bindValue(':like','%'.$like.'%');
    $query->execute();

    $suggestions ='<ul> Catégories :';
    while ($result = $query->fetch(PDO::FETCH_ASSOC)){
        $suggestions .= '
<li>
    <input type="hidden" name="idcategory" value="'.$result["idcategory"].'">
    <button type="submit" name="action" value="showCategory">'.$result["name"].'</button>
</li>';
    }
    $suggestions .='</ul>';

    $query = $pdo->prepare('SELECT * FROM TICKET WHERE UPPER(title) LIKE UPPER(:like) or UPPER(message) LIKE UPPER(:like) ORDER BY UPPER(title) LIMIT 5');
    $query->bindValue(':like','%'.$like.'%');
    $query->execute();

    $suggestions .='<ul> Billets :';
    while ($result = $query->fetch(PDO::FETCH_ASSOC)){
        $suggestions .= '
<li>
    <input type="hidden" name="idticket" value="'.$result["idticket"].'">
    <button type="submit" name="action" value="showTicket">'.$result["title"].'</button>
</li>';
    }
    $suggestions .='</ul>';

    $query = $pdo->prepare('SELECT * FROM COMMENT WHERE UPPER(text) LIKE UPPER(:like) ORDER BY UPPER(text) LIMIT 5');
    $query->bindValue(':like','%'.$like.'%');
    $query->execute();

    $suggestions .='<ul> Commentaires :';
    while ($result = $query->fetch(PDO::FETCH_ASSOC)){
        $suggestions .= '
<li>
    <input type="hidden" name="idcomment" value="'.$result["idcomment"].'">
    <button type="submit" name="action" value="showComment">'.$result["text"].'</button>
</li>';

    }
    $suggestions .='</ul>';


    echo $suggestions;
}
