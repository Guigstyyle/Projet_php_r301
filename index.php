<!DOCTYPE html>
<html lang="fr">
<head>
    <title> Index </title>
    <meta name="description" content="Ceci est la page d'acceuil de notre site sous forme de mur social de type blog.">
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

    <!-- Formulaire du LOGIN -->
    <form action="login.php" method="post">
        <h2> LOGIN</h2>
        <?php if(isset($_GET['error'])) {?>
            <p class="error"> <?php echo $_GET['error'] ?> </p>
        <?php } ?>
        <br><label> User Name</label>
        <input type="text" name="uname" placeholder ="User Name"><br>

        <label> Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit"> Login </button>
        <a href="signup.php" class="ca">Create an account</a>
    </form>
</body>
</html>
