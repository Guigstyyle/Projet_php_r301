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
<header></header>
<body>
<header>

    <form method="post" action="index.php">
        <button>Accueil</button>
        <?php if (isset($_SESSION['suid'])) {
            echo '<button type="submit" name="action" value="logout">Logout</button>';
            echo '<button type="submit" name="action" value="toPost">Poster</button>';
            if ($_SESSION['user']->getAdministrator()) {
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
<br>
<br>
<br>
<button id="test">test</button>

</body>
</html>
<?php
}
}