<!DOCTYPE html>
<html lang="fr">
<head>
    <title> Index </title>
    <meta name="description" content="Ceci est la page d'accueil de notre site sous forme de mur social de type blog.">
    <link rel="stylesheet" type="text/css" href="_Assets/Styles/style.css">
    <link rel="icon" type="favicon.ico" href="_Assets/Images/favicon.ico">
</head>
<body>
    <!-- Menu permanent -->

    <nav id="menu">
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Catégories</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contacts</a></li>
        </ul>
    </nav>

    <button id="newPostBtn">Nouveau Post</button>

    <div id="postForm" style="display:none;">
        <form id="postFormContent">
            <label for="username">Pseudo:</label>
            <input type="text" id="username" required><br>

            <label for="postTitle">Titre du Post:</label>
            <input type="text" id="postTitle" required><br>

            <label for="category">Catégorie:</label>
            <select id="category" required>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
            </select><br>

            <label for="postContent">Contenu du Post:</label><br>
            <textarea id="postContent" rows="4" cols="50" required></textarea><br>

            <button type="submit">Publier</button>
        </form>
    </div>

    <div id="posts"></div>

    <script src="script.js"></script>
</body>
</html>
