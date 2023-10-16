<?php


require_once __DIR__ . '/../view/user/Login.php';
require_once __DIR__ . '/../view/ErrorPage.php';
require_once __DIR__ . '/../model/UserModel.php';

class LoginController
{
    public function execute()
    {
        if ($_POST['action'] === 'login') {
            $this->connectUser();
        }
        if ($_POST['action'] === 'toLogin') {
            (new Login())->show();
        }
    }

    public function connectUser(): bool
    {
        if (!$this->validateLoginForm()) {
            return false;
        }
        $usernameOrMail = $_POST['usernameOrMail'];
        $password = $_POST['password'];
        $user = new \UserModel($usernameOrMail, $password);
        $user->updateLastConnection();
        return true;
    }

    public function validateLoginForm(): bool
    {
        try {
            if (empty($_POST['usernameOrMail']) or empty($_POST['password'])) {
                throw new Exception('Remplir tous les champs.');
            }

            $usernameOrMail = $_POST['usernameOrMail'];
            $password = $_POST['password'];

            if (!\UserModel::verifyPassword($usernameOrMail, $password)) {
                throw new Exception('Login ou mot de passe invalide.');
            }
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
        echo 'oui';
        return true;

    }

}