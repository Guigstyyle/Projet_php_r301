<?php

final class userControler
{

    function validate($data) //valide le format des données
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function registerUser() { // envoie les données necessaire au model pour la creation d'un compte
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $this->validate($_POST['mail']);
            $username = validate($_POST['username']);
            $password = validate($_POST['password']);
            $frontname = validate($_POST['frontname']);

            $userModel = new UserModel();
            $userModel->createUser($email, $password, $username, $frontname);
        }
    }

    public function loginUser() { // envoie les données necessaire au model pour la connexion d'un utilisateur
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $userModel->checkLogin($email, $password);

        }
    }

}
