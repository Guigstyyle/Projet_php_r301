<?php

class ForgotPassword
{
    public function setContent(){
        return <<<HTML

<form method="post" action="index.php">
    Saisissez votre adresse mail pour recevoir un mot de passe temporaire;
    <label>
        Adresse mail :<br>
        <input type="email" name="mail" placeholder="adresse@exemple.com">
    </label>
    <button type="submit" name="action" value="forgotPassword">Envoyer</button>
</form>
HTML;

    }
    public function show($sent = null){
        $content = $this->setContent();
        if (isset($sent)){
            $content .='Si l\'adresse fournie est valide vous allez recevoir un mail.';
        }
        (new Layout('Récupération de mot de passe',$content))->show();
    }
}