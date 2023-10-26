<?php

class Layout {
private $title;
private $content;
public function __construct(string $title, string $content)
{
    $this->content = $content;
    $this->title = $title;
}
public function show(): void {
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?= $this->title; ?></title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<header>
    <form method="post" action="index.php">
        <button>Accueil</button>
        <input id="searchBar" type="search" name="searchLike" placeholder="billet, catégorie, commentaire" autocomplete="off">
        <ul id="suggestions">

        </ul>
        <button type="submit" name="action" value="toSearch">Rechercher</button>
        <?php if (isset($_SESSION['suid'])) {
            echo '<button type="submit" name="action" value="logout">Logout</button>';
            if ($_SESSION['user']->getDeactivated() === 0) {
                echo '<button type="submit" name="action" value="toPost">Poster</button>';
            }
            echo '<button type="submit" name="action" value="toAccountPage">Mon Profil</button>';
            if ($_SESSION['user']->getAdministrator() and $_SESSION['user']->getDeactivated() === 0) {
                echo '<button type="submit" name="action" value="toAdminPage">Admin</button>';
            }
        } else {
            echo '<button type="submit" name="action" value="toLogin">Login</button>';
            echo '<button type="submit" name="action" value="toRegister">Créer un compte</button>';
        } ?>
    </form>
</header>

<h1>Page de <?= $this->title; ?></h1>
<?= $this->content; ?>
<footer></footer>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/AllAutosuggest.js"></script>
</body>
</html>
<?php
}
}