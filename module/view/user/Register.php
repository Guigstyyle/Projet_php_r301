<?php


require_once __DIR__ . '/../Layout.php';

class Register
{
    public function setContent(): string
    {
        return <<<HTML
<form class="userForm" id="registerForm" method="post" action="index.php">
    <label for="username">Nom d'utilisateur* :</label>
    <input id="username" type="text" name="username" placeholder="Nom d'utilisateur" maxlength="100">
    
    <label for="frontname">Pseudo :</label>
    <input id="frontname" type="text" name="frontname" placeholder="Pseudo" maxlength="255">
    
    <label for="mail">Adresse mail* :</label>
    <input id="mail" type="text" name="mail" placeholder="adresse@exemple.com" maxlength="255">
    
    <label for="password">Mot de passe* :</label>
    <input id="password" type="password" name="password" placeholder="Mot de passe" maxlength="255">
    
    <label for="verifPassword">Mot de passe a nouveau* :</label>
    <input id="verifPassword" type="password" name="verifPassword" placeholder="Même mot de passe" maxlength="255">
    
    <div class="buttonContainer">
        <button type="reset">Effacer</button>
        <button type="submit" name="action" value="register">Créer le compte</button>
    </div>
</form>
HTML;
    }

    public function show()
    {
        (new Layout('création de compte', $this->setContent()))->show();
    }
}