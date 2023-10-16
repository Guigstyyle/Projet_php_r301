<?php

namespace controller;

require_once __DIR__ . '/../view/user/Register.php';
require_once __DIR__ . '/../model/UserModel.php';

class RegisterController
{
    public function execute()
    {
        if ($_POST['action'] === 'register') {
            $this->register();
        }
        if ($_POST['action'] === 'toRegister'){
            (new Register())
        }
    }

    public function register()
    {
        if ($this->validateRegisterForm()) {
            $username = $_POST['username'];
            $mail = $_POST['mail'];
            $password = $_POST['password'];
            $frontname = $_POST['frontname'];
            if (empty($frontname)){
                $user = new \UserModel($username, $mail, $password);
            }
            else{
                $user = new \UserModel($username, $mail, $password,$frontname);
            }

        }
    }

    /**
     * @return bool if the form is valid
     * @uses validatePasswordForm to make sure the password is secure
     * @uses \UserModel::usernameExists() to check that the username does not already exist
     * @uses \UserModel::mailExists() to check that the mail does not already exist
     * @description : Checks if the form is valid
     */
    public function validateRegisterForm(): bool
    {
        try {


            if (empty($_POST['username']) or
                empty($_POST['mail']) or
                empty($_POST['password'])) {

                throw new \Exception('Remplir tous les champs.');
            }
            if (!$this->validatePasswordForm()) {
                throw new \Exception('Le mot de passe doit contenir 8 caractères dont :\n   -Une majuscule\n    -Une minuscule\n    -Un chiffre\n -Un caractère spécial');
            }
            if (\UserModel::usernameExists($_POST['username'])) {
                throw new \Exception('Le username existe déjà.');
            }
            if (\UserModel::mailExists($_POST['mail'])) {
                throw new \Exception('L\'adresse est déjà utilisé.');
            }
            return true;
        }catch (\Exception $exception){
            (new \ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @return false|int (1 or 0)
     * @description Checks if the password is at least 8 characters long has a digit,
     * a capital letter, a lowercase letter, a digit and a special character by using a regex.
     **/
    public function validatePasswordForm()
    {
        $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        return (preg_match($password_regex, $_POST['password']));
    }
}