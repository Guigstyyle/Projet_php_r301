<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>


    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title> HOME </title>
        <link rel="stylesheet" type="text/css" href="_Assets/style/style.css">
    </head>
    <body>
    <h1> Hello, <?php echo $_SESSION['user_name'] ?></h1>
    <a href="module/Controler/logout.php"> Logout</a>
    </body>
    </html>
    <?php
}else {
    header("Location: index.php");
    exit();
}
?>