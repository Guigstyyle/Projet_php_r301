<?php

require_once __DIR__ . '/../Layout.php';

class Login
{
    public function setContent(): string
    {
        return <<<HTML
<form class="userForm" id="loginForm" method="post" action="index.php">
    <label for="loginField">Identifiant :</label>
    <input id="loginFiled" type="text" name="usernameOrMail" placeholder="Identidiant ou mail" maxlength="255">
    
    <label for="passwordField">Mot de passe :</label>        
    <input id="passwordField" type="password" name="password" placeholder="Mote de passe" maxlength="255">
    
    <div class="buttonContainer">
        <button type="submit" name="action" value="toForgotPassword">Mot de passe oublié</button>
        <button type="reset" name="cancel">Effacer</button>
        <button type="submit" name="action" value="login">Se connecter</button>
    </div> 
</form>
HTML;
    }

    public function show(): void
    {
        (new Layout('Connexion', $this->setContent()))->show();
    }


}
