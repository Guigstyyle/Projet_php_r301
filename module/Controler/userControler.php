<?php

final class userControler
{

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function registerAction() {
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = validate($_POST['uname']);
            $password = validate($_POST['password']);

            $re_pass = validate($_POST['re_password']);
            $name = validate($_POST['name']);

            $user_data = 'uname=' . $username . '&name=' . $name;

            $userModel = new UserModel();
            $userModel->createUser($username, $password);
        }
    }


    public function loginAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Appelez le modèle pour vérifier les informations de connexion
            $userModel = new UserModel();
            $userModel->checkLogin($email, $password);

        }
    }

    public function logoutAction()
    {

        Vue::montrer('helloworld/testform', array('formData' =>  $A_postParams));

    }

}
