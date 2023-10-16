<?php

namespace view\user;
class Register
{
public function serContent(){
    return ?>
<form method="post" action="index.php">
    <label>
        Nom d'utilisateur* :<br>
        <input type="text" name="username" placeholder="Nom d'utilisateur"><br>
    </label>
    <label>
        Pseudo :<br>
        <input type="text" name="frontname" placeholder="Pseudo"><br>
    </label>
    <label>
        Adresse mail* :<br>
        <input type="text" name="mail" placeholder="adresse@exemple.com"><br>
    </label>
    <label>
        Mot de passe* :<br>
        <input type="password" name="password" placeholder="Mot de passe"><br>
    </label>
    <label>
        Mot de passe a nouveau* :<br>
        <input type="password" name="verifPassword" placeholder="Même mot de passe"><br>
    </label>

</form>
}
}