<?php


require_once __DIR__ . '/../Layout.php';

class Register
{
    public function setContent(): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <label>
        Nom d'utilisateur* :<br>
        <input type="text" name="username" placeholder="Nom d'utilisateur" maxlength="100"><br>
    </label>
    <label>
        Pseudo :<br>
        <input type="text" name="frontname" placeholder="Pseudo" maxlength="255"><br>
    </label>
    <label>
        Adresse mail* :<br>
        <input type="text" name="mail" placeholder="adresse@exemple.com" maxlength="255"><br>
    </label>
    <label>
        Mot de passe* :<br>
        <input type="password" name="password" placeholder="Mot de passe" maxlength="255"><br>
    </label>
    <label>
        Mot de passe a nouveau* :<br>
        <input type="password" name="verifPassword" placeholder="Même mot de passe" maxlength="255"><br>
    </label>
    <button type="reset">Effacer</button>
    <button type="submit" name="action" value="register">Créer le compte</button>
    
</form>
HTML;
    }

    public function show()
    {
        (new Layout('création de compte', $this->setContent()))->show();
    }
}