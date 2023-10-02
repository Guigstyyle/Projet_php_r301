<!DOCTYPE html>
<html>
<head>
    <title>SIGN UP</title>
    <meta name="description" content="Ceci est la page de création de compte de notre site sous forme de mur social de type blog.">
    <link rel="stylesheet" type="text/css" href="_Assets/Styles/style.css">
    <link rel="icon" type="favicon.ico" href="_Assets/Images/favicon.ico">
</head>
<body>
<form action="../Controler/user/register-controler.php" method="post">
    <h2>SIGN UP</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>

    <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
    <?php } ?>

    <label>Name</label>
    <?php if (isset($_GET['name'])) { ?>
        <input type="text"
               name="name"
               placeholder="Name"
               value="<?php echo $_GET['name']; ?>"><br>
    <?php }else{ ?>
        <input type="text"
               name="name"
               placeholder="Name"><br>
    <?php }?>

    <label>User Name</label>
    <?php if (isset($_GET['uname'])) { ?>
        <input type="text"
               name="uname"
               placeholder="User Name"
               value="<?php echo $_GET['uname']; ?>"><br>
    <?php }else{ ?>
        <input type="text"
               name="uname"
               placeholder="User Name"><br>
    <?php }?>


    <label>Password</label>
    <input type="password"
           name="password"
           placeholder="Password"><br>

    <label>Confirm Password</label>
    <input type="password"
           name="confirm password"
           placeholder="Confirm Password"><br>

    <button type="submit">Sign Up</button>
    <a href="login-view.php" class="ca">Already have an account?</a>
</form>
</body>
</html>