<?php
require_once __DIR__ . '/../view/user/AccountPage.php';

require_once __DIR__ . '/../model/UserModel.php';

class AccountPageController
{
    public function execute()
    {
        $action = $_POST['action'];
        if ($action === 'toAccountPage') {
            (new AccountPage())->show();
        }

        if ($action === 'changeInformations') {
            session_start();
            if ($this->changeInformations()){
                (new AccountPage())->show();
            }
        }
        if ($action === 'changePassword') {
            session_start();
            if ($this->changePassword()){
                (new AccountPage())->show();
            }
        }
    }

    public function changeInformations(): bool
    {
        $user = $_SESSION['user'];
        if ($this->validateChangeInformationsForm($user)) {
            $username = $_POST['username'];
            $mail = $_POST['mail'];
            $frontname = $_POST['frontname'] ?? $username;

            if ($username !== $user->getUsername()) {
                $user->setUsername($username);
            }
            if ($mail !== $user->getMail()) {
                $user->setmail($mail);
            }
            if ($frontname !== $user->getFrontname()) {
                $user->setFrontname($frontname);
            }
            return true;
        }
        return false;
    }

    /**
     * @param $user
     * @return bool
     * @todo Verify input and handle errors
     */
    public function validateChangeInformationsForm($user): bool
    {

        if (empty($_POST['username'] or empty($_POST['mail']))) {
            return false; //empty field(s)
        }
        if (empty($_POST['password'])) {
            return false; //password empty
        }
        $username = $_POST['username'];
        $mail = $_POST['mail'];

        if ($username !== $user->getUsername()) {
            if (UserModel::usernameExists($username)) {
                return false; //Username already exists
            }
        }
        if ($mail !== $user->getMail()) {
            if (UserModel::mailExists($mail)) {
                return false; //Mail already exists
            }
        }
        $password = $_POST['password'];
        if ($password !== $user->getPassword()) {
            return false; //Wrong password
        }
        return true;
    }

    public function changePassword(): bool
    {
        $user = $_SESSION['user'];
        if ($this->validateChangePasswordForm($user)) {
            $user->setPassword($_POST['newPassword']);
            return true;
        }
        return false;
    }

    public function validateChangePasswordForm($user): bool
    {
        if (empty($_POST['password']) or empty($_POST['newPassword']) or empty($_POST['newPasswordConfirm'])) {
            return false;//empty field(s)
        }
        $password = $_POST['password'];
        $newPassword = $_POST['newPassword'];
        $newPasswordConfirm = $_POST['newPasswordConfirm'];
        if ($newPasswordConfirm !== $newPassword){
            return false;//not matching passwords
        }
        if (!$this->validatePasswordRegex($newPassword)){
            return false;//regex not passed
        }
        if (!UserModel::verifyPassword($user->getUsername(),$password)){
            return false;//Wrong current password
        }
        if ($newPassword === $password){
            return false;//Same password as before
        }
        return true;

    }
    public function validatePasswordRegex($password): bool
    {
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        return (preg_match($password_regex, $password));
    }
}