<?php


require_once __DIR__ . '/../view/user/Login.php';
require_once __DIR__ . '/../view/ErrorPage.php';
require_once __DIR__ . '/../model/UserModel.php';

class LoginController
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        if ($_POST['action'] === 'login') {
            if ($this->connectUser()) {
                (new Homepage())->show(TicketModel::getFiveLast());
            }
        }
        if ($_POST['action'] === 'toLogin') {
            (new Login())->show();
        }
    }

    /**
     * @return bool
     * @throws Exception
     * @uses LoginController::validateLoginForm() to check for any errors in the form.
     * @description sets the suid and the user (a UserModel) keys in $_SESSION updates the lastconnection attribute of the user.
     */
    public function connectUser(): bool
    {
        if (!$this->validateLoginForm()) {
            return false;
        }
        $usernameOrMail = $_POST['usernameOrMail'];
        $password = $_POST['password'];
        $user = new UserModel($usernameOrMail, $password);
        $user->updateLastConnection();
        session_start();
        $_SESSION['suid'] = session_id();
        $_SESSION['user'] = $user;

        return true;
    }

    /**
     * @return bool
     * @throws Exception
     * @uses UserModel::verifyPassword() to check that the password corresponds to the login.
     * @description Verifies that all fields are filled and that the password is correct.
     */
    public function validateLoginForm(): bool
    {
        try {
            if (empty($_POST['usernameOrMail']) or empty($_POST['password'])) {
                throw new Exception('Remplir tous les champs.');
            }

            $usernameOrMail = $_POST['usernameOrMail'];
            $password = $_POST['password'];

            if (!UserModel::verifyPassword($usernameOrMail, $password)) {
                throw new Exception('Login ou mot de passe invalide.');
            }
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
        return true;

    }

}