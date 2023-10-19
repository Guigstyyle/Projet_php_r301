<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <title> login </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="favicon.ico" href="_Assets/Images/favicon.ico">
</head>
<body>
    <form action="login.php" method="post">
        <h2> LOGIN</h2>
        <?php /*if(isset($_GET['error'])) {?>
            <p class="error"> <?php echo $_GET['error'] ?> </p>
        <?php } */?>
        <br><label> User Name</label>
        <input type="text" name="uname" placeholder ="User Name"><br>

        <label> Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit"> Login </button>
        <a href="signup.php" class="ca">Create an account</a>
    </form>
</body>
</html> -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use ctrl\UserController;


// Inclure le modèle de base
require 'module/model/userModel.php';


// Récupérer l'URI de la demande
$requeteUri = $_SERVER['REQUEST_URI'];

// Supprimer les paramètres de l'URL
$cleanUri = strtok($requeteUri, '?');

// Divisez l'URI en segments en utilisant '/'
$uriSegments = explode('/', trim($cleanUri, '/'));

$controllerName = isset($uriSegments[0]) ? ucfirst($uriSegments[0]) . 'Controler' : 'AccueilControler';
$action = isset($uriSegments[1]) ? $uriSegments[1] : 'accueil';

// Récupérer le nom du contrôleur depuis l'URL
//$controllerName = isset($_GET['Controller']) ? $_GET['Controller'] : 'Accueil';

// Ajoutez ici la logique pour valider et sécuriser le nom du contrôleur, par exemple, en vérifiant qu'il correspond à un contrôleur existant.

// Inclure le fichier du contrôleur spécifié
$controllerFile = "Controler/{$controllerName}.php";
//$controllerFile ="ctrl/{$controllerName}Controller.php";

if (file_exists($controllerFile)) {
    require $controllerFile;

    // Instancier le contrôleur
    //$controllerClassName = $controllerName . 'Controller';
    $controller = new $controllerName();

    // Récupérer la méthode depuis l'URL
    // $action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

    // Vérifier si la méthode existe dans le contrôleur
    if (method_exists($controller, $action)) {
        call_user_func(array($controller, $action));
    } else {
        include('module/view/404.php');
    }
} else {
    include('module/view/login-view.php');
}