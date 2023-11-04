<?php


require_once __DIR__ . '/../view/user/Register.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../view/ErrorPage.php';
require_once __DIR__ . '/../view/Homepage.php';

class RegisterController
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        if ($_POST['action'] === 'register') {
            if ($this->registerUser()) {
                (new Homepage())->show(TicketModel::getFiveLast());
            }

        }
        if ($_POST['action'] === 'toRegister') {
            (new Register())->show();
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function registerUser(): bool
    {
        if (!$this->validateRegisterForm()) {
            return false;
        }
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $frontname = $_POST['frontname'];
        if (empty($frontname)) {
            $user = new UserModel($username, $mail, $password);
        } else {
            $user = new UserModel($username, $mail, $password, $frontname);
        }
        session_start();
        $_SESSION['suid'] = session_id();
        $_SESSION['user'] = $user;

        return true;
    }

    /**
     * @return bool if the form is valid
     * @throws Exception
     * @description : Checks if the form is valid
     * @uses UserModel::usernameExists() to check that the username does not already exist
     * @uses UserModel::mailExists() to check that the mail does not already exist
     * @uses RegisterController::validatePasswordRegex() to make sure the password is secure
     * @uses RegisterController::doubleCheckPassword() to make sure the password is correctly typed
     */
    public function validateRegisterForm(): bool
    {
        try {
            if (empty($_POST['username']) or
                empty($_POST['mail']) or
                empty($_POST['password']) or
                empty($_POST['verifPassword'])) {

                throw new \Exception('Remplir tous les champs avec \'*\'.');
            }
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Adresse invalide');
            }
            if (!$this->validatePasswordRegex($_POST['password'])) {
                throw new \Exception('Le mot de passe doit contenir 8 caractères dont :<br>' . PHP_EOL . '      -Une majuscule<br>' . PHP_EOL . '     -Une minuscule<br>' . PHP_EOL . '      -Un chiffre<br>' . PHP_EOL . '     -Un caractère spécial');
            }
            if (!$this->validateUsernameRegex($_POST['username'])){
                throw  new Exception('Le nom d\'utilisateur ne peu contenir que des lettres, des chiffres aisni que les caractères suivant : ._*-~@#');
            }
            if (!$this->doubleCheckPassword($_POST['password'], $_POST['verifPassword'])) {
                throw new \Exception('Les mots de passe ne correspondent pas.');
            }
            if (UserModel::usernameExists($_POST['username'])) {
                throw new \Exception('Le username existe déjà.');
            }
            if (UserModel::mailExists($_POST['mail'])) {
                throw new \Exception('L\'adresse est déjà utilisé.');
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @return false|int (1 or 0)
     * @description Checks if the password is at least 8 characters long has a digit,
     * a capital letter, a lowercase letter, a digit and a special character by using a regex.
     **/
    public function validatePasswordRegex($password): bool
    {
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        return (preg_match($password_regex, $password));
    }
    public function validateUsernameRegex($username): bool
    {
        $usernameRegex = "/^[a-zA-Z0-9._*\-~@#]*$/";
        return (preg_match($usernameRegex, $username));
    }

    /**
     * @param $password
     * @param $passwordAgain
     * @return bool
     * @description Checks if the user correctly typed his password
     */
    public function doubleCheckPassword($password, $passwordAgain): bool
    {
        return $password === $passwordAgain;
    }
}