<?php

namespace Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class userModel
{
    public static function checkEmailExists($email) // verifie si l'email existe déjà
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $requete = db_conn::connectDB()->prepare($query);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }

    public static function checkUsernameExists($username) // verifie si l'username existe déjà
    {

        $query = "SELECT * FROM users WHERE username = :username";
        $requete = db_conn::connectDB()->prepare($query);
        $requete->bindParam(':username', $username, PDO::PARAM_STR);
        $requete->execute();

        $result = $requete->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }


    public function createUser($email, $password, $username, $frontname){ // fonction de création de l'utilisateur grace aux données envoyer par le controlleur
        if($this->checkEmailExists($email)){
            header('Location: ../../index.php?erreur=email_existe_deja');
            exit();
        }
        elseif ($this->checkUsernameExists($username)){
            header('Location: ../../index.php?erreur=username_existe_deja');
        }
        else {
            $password = md5($password);
            $query = 'INSERT into users (email, password, username, frontname) values (:email, :password, :username, :frontname)';
            $requete = db_conn::connectDB->connectDB()->prepare($query);
            $requete->bindParam(':email', $email, PDO::PARAM_STR);
            $requete->bindParam(':mot_de_passe', $password, PDO::PARAM_STR);
            $requete->bindParam(':username', $username, PDO::PARAM_STR);
            $requete->bindParam(':frontname', $frontname, PDO::PARAM_STR);
            $requete->execute();

            $userModel = new UserModel();
            $userModel->checkLogin($email, $password);
            exit;
        }
    }

    public function checkLogin($email, $password ) // verifie si l'utilisateur a déjà un compte
    {
        $query = "SELECT * FROM users WHERE (email = :email)";
        $requete = db_conn::connectDB()->prepare($query);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->execute();

        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);


        if ($utilisateur && password_verify($password, $utilisateur['mdp'])) {

            session_start();
            $_SESSION['user_connecte'] = true;
            $_SESSION['email'] = $utilisateur['email'];
            $_SESSION['username'] = $utilisateur['username'];

            // Redirigez l'utilisateur vers une view
            header('Location: ../views/dashboard.php');
            exit;
        } else {
            // Le mot de passe ne correspond pas
            header('Location: ../index.php?erreur=mot_de_passe_incorrect');
            exit;
        }
    }
}