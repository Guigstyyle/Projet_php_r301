<?php

class Layout
{
    private $title;
    private $content;

    public function __construct(string $title, string $content)
    {
        $this->content = $content;
        $this->title = htmlspecialchars($title);
    }

    public function show(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <title><?= $this->title; ?></title>
            <meta
                charset="UTF-8"
                name="description"
                content="Ceci est la page d'accueil de notre site sous forme de mur social de type blog."/>
            <link rel="stylesheet" type="text/css" href="_assets/styles/style.css">
        </head>
        <body>

        <!-- Menu permanent -->

        <form class="nav" method="post" action="index.php">


            <ul class="ul-nav">
                <li>
                    <button class="accueil">Accueil</button>
                </li>
                <li class="deroulant"><a href="#">Recherche ▼</a>
                    <ul class="sous">
                        <li><input id="searchBar" type="search" name="searchLike"
                                   placeholder="billet, catégorie, commentaire" autocomplete="off"></li>
                        <li>
                            <button class="button" type="submit" name="action" value="toSearch">Recherche</button>
                        </li>
                        <li>
                            <ul id="suggestionsAll"></ul>
                        </li>
                    </ul>
                </li>

                <?php if (isset($_SESSION['suid'])) {

                    echo '<li><button type="submit" name="action" value="logout">Logout</button></li>';
                    if ($_SESSION['user']->getDeactivated() === 0) {
                        echo '<li><button type="submit" name="action" value="toPost">Poster</button></li>';
                    }
                    echo '<li><button type="submit" name="action" value="toAccountPage">Mon Profil</button></li>';
                    echo '<li><button type="submit" name="action" value="toMentionPage">Mes mentions</button></li>';
                    if ($_SESSION['user']->getAdministrator() and $_SESSION['user']->getDeactivated() === 0) {
                        echo '<li><button type="submit" name="action" value="toAdminPage">Admin</button></li>';

                    }
                } else { ?>

                    <li class="deroulant"><a href="#">Compte ▼</a>
                        <ul class="sous">
                            <li>
                                <button class="button" type="submit" name="action" value="toLogin">Login</button>
                            </li>
                            <li>
                                <button class="button" type="submit" name="action" value="toRegister">Créer un compte
                                </button>
                            </li>
                        </ul>
                    </li> <?php } ?>
            </ul>

        </form>
        <section class="pageContainer">
        <h1><?= $this->title; ?></h1>


        <?= $this->content; ?>
        </section>
        <footer>
            <hr/>
            <h3>Contact</h3>
            <p>Pour nous contacter veuiller ecrire un mail a l'addresse mail suivante : zozo@zizi.com</p>
        </footer>
        <script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
        <script src="/_assets/scripts/AllAutosuggest.js"></script>
        </body>
        </html>


        <?php

    }
}