<?php
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../view/user/ForgotPassword.php';
class ForgotPasswordController
{
    public function execute(){
        $action = $_POST['action'];
        if ($action === 'toForgotPassword'){
            (new ForgotPassword())->show();
        }
        if ($action === 'forgotPassword'){
            $this->sendNewPassword();
            (new ForgotPassword())->show(1);
        }
    }
    public function sendNewPassword(){
        $mail = $_POST['mail'];
        if(UserModel::mailExists($mail)){
            $password = $this->random_password();
            $user = new UserModel($mail);
            $user->setPassword($password);

            $from = 'postmaster@localhost.net';
            $message = 'Voici votre nouveau mot de passe, changez le dès que possile :' . PHP_EOL;
            $message .= 'Mot de passe : ' . $password . PHP_EOL;
            mail($mail, 'Inscription', $message, 'From:' . $from);
        }
    }
    function random_password(): string
    {
        $random_characters = 2;

        $lower_case = "abcdefghijklmnopqrstuvwxyz";
        $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numbers = "1234567890";
        $symbols = "!@#$%^&*";

        $lower_case = str_shuffle($lower_case);
        $upper_case = str_shuffle($upper_case);
        $numbers = str_shuffle($numbers);
        $symbols = str_shuffle($symbols);

        $random_password = substr($lower_case, 0, $random_characters);
        $random_password .= substr($upper_case, 0, $random_characters);
        $random_password .= substr($numbers, 0, $random_characters);
        $random_password .= substr($symbols, 0, $random_characters);

        return  str_shuffle($random_password);
    }
}