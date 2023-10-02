<!DOCTYPE html>
<html lang="fr">
<head>
    <title> login </title>
    <link rel="stylesheet" type="text/css" href="_Assets/style/style.css">
    <link rel="icon" type="favicon.ico" href="_Assets/Images/favicon.ico">
</head>
<body>
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
