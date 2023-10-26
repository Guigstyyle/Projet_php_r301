<?php

class AccountPage
{
    public function setContent($user){
        $username = $user->getUsername();
        $frontname = $user->getFrontname();
        $mail = $user->getMail();
        $lastconnection = date('d/m/y H:i',strtotime($user->getLastconnection()));
        return <<<HTML
<label>Dernière connexion : {$lastconnection}</label>
<form method="post" action="index.php">
    <label>
        Nom d'utilisateur :<br>
        <input type="text" name="username" value="{$username}" placeholder="Nom d'utilisateur" maxlength="100"><br>
    </label>
    <label>
        Pseudo :<br>
        <input type="text" name="frontname" value="{$frontname}" placeholder="Pseudo" maxlength="255"><br>
    </label>
    <label>
        Adresse mail :<br>
        <input type="text" name="mail" value="{$mail}" placeholder="adresse@exemple.com" maxlength="255"><br>
    </label>
    <label>
        Mot de passe :<br>
        <input type="password" name="password" placeholder="Mot de passe" maxlength="255"><br>
    </label>
    <button type="submit" name="action" value="changeInformations">Enregistrer</button><br>
    
</form>

<label>Changer de mot passe</label>
<form method="post" action="index.php">
    <label>
        Mot de passe actuel :<br>
        <input type="password" name="password" placeholder="Mot de passe actuel" maxlength="255"><br>
    </label>
    <label>
        Nouveau mot de passe :<br>
        <input type="password" name="newPassword" placeholder="Nouveau mot de passe" maxlength="255"><br>
    </label>
    <label>
        Confirmation du nouveau mot de passe :<br>
        <input type="password" name="newPasswordConfirm" placeholder="Confirmation mot de passe" maxlength="255"><br>
    </label>
    <button type="submit" name="action" value="changePassword">Changer de mot de passe</button>
</form>
HTML;
    }

    public function show(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        (new Layout('compte de '.$user->getUsername(),$this->setContent($user)))->show();
    }
}