<?php

class AccountPage
{
    public function setContent($user): string
    {
        $username = $user->getUsername();
        $frontname = $user->getFrontname();
        $mail = $user->getMail();
        $lastconnection = date('d/m/y H:i', strtotime($user->getLastconnection()));
        return <<<HTML

<small>Dernière connexion : {$lastconnection}</small>
<h2>Modifier mes informations</h2>
<form class="userForm" id="editProfilForm" method="post" action="index.php">

    <label for="username">Nom d'utilisateur :</label>
    <input id="username" type="text" name="username" placeholder="Nom d'utilisateur" value="{$username}" maxlength="100">
    
    <label for="frontname">Pseudo :</label>
    <input id="frontname" type="text" name="frontname" placeholder="Pseudo" value="{$frontname}" maxlength="255">
    
    <label for="mail">Adresse mail :</label>
    <input id="mail" type="text" name="mail" placeholder="adresse@exemple.com" value="{$mail}" maxlength="255">
  

    <label for="password">Mot de passe* :</label>
    <input id="password" type="password" name="password" placeholder="Mot de passe" maxlength="255">
    <div class="buttonContainer">
        <button type="submit" name="action" value="changeInformations">Enregistrer</button>
    </div>
</form>

<h2>Changer de mot passe</h2>
<form class="userForm" id="changePasswordForm" method="post" action="index.php">
    <label for="password">Mot de passe actuel :</label>
    <input type="password" name="password" placeholder="Mot de passe actuel" maxlength="255">
 
    <label for="newPassword">Nouveau mot de passe :</label>
    <input id="newPassword" type="password" name="newPassword" placeholder="Mot de passe" maxlength="255">
    
    <label for="verifNewPassword">Confirmation du nouveau mot de passe:</label>
    <input id="verifNewPassword" type="password" name="newPasswordConfirm" placeholder="Même mot de passe" maxlength="255">
    
    <div class="buttonContainer">
        <button type="submit" name="action" value="changePassword">Changer de mot de passe</button>
    </div>
</form>

HTML;
    }

    public function show()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        (new Layout('compte de ' . $user->getUsername(), $this->setContent($user)))->show();
    }
}