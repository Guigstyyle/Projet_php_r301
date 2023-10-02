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
    public function connectDB()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=login_db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function createUser($email, $username, $password){
        $query = 'INSERT into users (email, username, password) values (:email, :username, ;password)';
        $password = md5($password);
        $test = this->connectDB()->prepare($query);
        $test->execute();
        $userModel = new UserModel();
        $userModel->checkLogin($email, $password);
        exit;

    }

    public function checkLogin($username, $password){

    }
}