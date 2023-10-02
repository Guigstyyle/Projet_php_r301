<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Titre de votre page</title>
    <style>
        /* Ajoutez du CSS pour styliser le formulaire d'inscription */
        body {
            margin: 0; /* Supprimez la marge par défaut du corps de la page */
            padding: 0;
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #333;
            color: #fff;
            display: flex; /* Utilisation de flexbox */
            justify-content: space-between; /* Aligner les éléments à l'extrémité */
            align-items: center; /* Centrer verticalement */
            padding: 10px;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        /* Style du formulaire */
        #inscription {
            display: flex; /* Utilisation de flexbox */
            align-items: center; /* Centrer verticalement */
            margin-right: 10px;
        }
        /* Style des liens "S'inscrire" et "Se connecter" */
        .auth-links {
            text-decoration: none;
            color: #fff;
            margin-left: 20px;
        }
        /* Style pour le pied de page */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        /* Style de la barre de recherche */
        #barre-recherche {
            width: 300px;
            padding: 10px;
            margin-top: 20px;
            margin-left: auto; /* Déplacer la barre de recherche à droite */
            margin-right: 10px;
        }
        h1 {
            margin-left: 10px; /* Déplacer le nom du site à gauche */
        }
    </style>
</head>
<body>
<header>
    <h1>Mon Site Web</h1>
    <!-- Formulaire d'inscription et barre de recherche à droite -->
    <div id="inscription">
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <input type="text" id="barre-recherche" placeholder="Rechercher...">
        <a class="auth-links" href="#">S'inscrire</  a>
        <a class="auth-links" href="#">Se connecter</a>
    </div>
</header>

<main>
    <section>
        <h2>Section 1</h2>
        <p>Ceci est le contenu de la section 1.</p>
    </section>

    <section>
        <h2>Section 2</h2>
        <p>Ceci est le contenu de la section 2.</p>
    </section>
</main>

<footer>
    <p>Droit d'auteur © 2023 Mon Site Web</p>
</footer>
</body>
</html>



