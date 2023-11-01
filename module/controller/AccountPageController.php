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
            if ($this->changeInformations()) {
                (new AccountPage())->show();
            }
        }
        if ($action === 'changePassword') {
            session_start();
            if ($this->changePassword()) {
                (new AccountPage())->show();
            }
        }
    }

    /**
     * @return bool
     * @description verifies and changes information of the user and update the database
     * @uses $this->validateChangeInformationsForm();
     */
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
     * @todo Verify username input for special characters and all input for len limit
     */
    public function validateChangeInformationsForm($user): bool
    {

        try {
            if (empty($_POST['username'] or empty($_POST['mail']))) {
                throw new Exception('Certains champs sont vides.');
            }
            if (empty($_POST['password'])) {
                throw new Exception('Le mot de passe n\'est pas renseigné.');
            }
            $username = $_POST['username'];
            $mail = $_POST['mail'];

            if ($username !== $user->getUsername()) {
                if (UserModel::usernameExists($username)) {

                    throw new Exception('Le username existe déjà.');
                }
            }
            if ($mail !== $user->getMail()) {
                if (UserModel::mailExists($mail)) {
                    throw new Exception('Cette adresse est déjà utilisé.');
                }
            }
            $password = $_POST['password'];
            if (!password_verify($password, $user->getPassword())) {
                throw new Exception('Mot de passe incorrect.');
            }

        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
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
        try {
            if (empty($_POST['password']) or empty($_POST['newPassword']) or empty($_POST['newPasswordConfirm'])) {
                throw new Exception('Certains champs sont vides.');
            }
            $password = $_POST['password'];
            $newPassword = $_POST['newPassword'];
            $newPasswordConfirm = $_POST['newPasswordConfirm'];
            if ($newPasswordConfirm !== $newPassword) {
                throw new Exception('Les nouveaux mots de passe de correspondent pas.');
            }
            if (!$this->validatePasswordRegex($newPassword)) {
                throw new Exception('Le mot de passe doit contenir 8 caractères dont :<br>' . PHP_EOL . '      -Une majuscule<br>' . PHP_EOL . '     -Une minuscule<br>' . PHP_EOL . '      -Un chiffre<br>' . PHP_EOL . '     -Un caractère spécial');
            }
            if (!UserModel::verifyPassword($user->getUsername(), $password)) {
                throw new Exception('Mot de passe incorrect.');
            }
            if ($newPassword === $password) {
                throw new Exception('Le nouveau mot de passe doit être différent de l\'ancien.');
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }

    }

    public function validatePasswordRegex($password): bool
    {
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        return (preg_match($password_regex, $password));
    }
}