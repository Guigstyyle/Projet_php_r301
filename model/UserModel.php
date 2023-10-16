<?php
require_once 'DatabaseConnection.php';

class UserModel
{
    private $username;
    private $mail;
    private $password;
    private $frontname;
    private $firsconnection;
    private $lasconnection;
    private $administrator;
    private $deactivated;

    /**
     * @param $username
     * @param $mail
     * @param $password
     * @description Constructor used on registration of a new user
     * @todo same constructor but with frontname.
     */
    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        $constructor = method_exists(
            $this,
            $fn = "__construct" . $numberOfArguments
        );
        if ($constructor) {
            call_user_func_array([$this, $fn], $arguments);
        }
    }

    public function __construct2($usernameOrMail, $password)
    {
        $query = self::selectUsernameOrMail($usernameOrMail);

        if (!$query->execute()) {
            throw new Exception('Non valid query');
        } else {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->username = $result['username'];
            $this->mail = $result['mail'];
            $this->password = $result['password'];
            $this->frontname = $result['frontname'];
            $this->firsconnection = $result['firstconnection'];
            $this->lasconnection = date('Y-m-d H:i:s');
            $this->administrator = $result['administrator'];
            $this->deactivated = $result['deactivated'];
        }
    }

    public function __construct3($username, $mail, $password)
    {
        $this->attributeInitialisation($username, $mail, $password);
        $this->frontname = $username;
    }

    public function __construct4($username, $mail, $password, $frontname)
    {
        $this->attributeInitialisation($username, $mail, $password);
        $this->frontname = $frontname;
    }

    /**
     * @param $username
     * @param $mail
     * @param $password
     * @return void
     */
    public function attributeInitialisation($username, $mail, $password): void
    {
        $this->username = $username;
        $this->mail = $mail;
        $this->password = $password;
        $this->firsconnection = date('Y-m-d H:i:s');
        $this->lasconnection = date('Y-m-d H:i:s');
        $this->administrator = 0;
        $this->deactivated = 0;

        $this->registerUserToDatabase();
    }

    /**
     * @return bool
     * @description registers a new user to the database
     */
    public function registerUserToDatabase(): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare(
            'INSERT INTO USER (username, 
                  mail, password, frontname, 
                  firstconnection, lastconnection, 
                  administrator, deactivated) VALUES (:username, :mail,
                                                      :password, :frontname,
                                                      :firstconnection, :lastconnection,
                                                      :administrator, :deactivated)');
        $query->bindValue(':username', $this->username);
        $query->bindValue(':mail', $this->mail);
        $query->bindValue(':password', $this->password);
        $query->bindValue(':frontname', $this->frontname);
        $query->bindValue(':firstconnection', $this->firsconnection);
        $query->bindValue(':lastconnection', $this->lasconnection);
        $query->bindValue(':administrator', $this->administrator);
        $query->bindValue(':deactivated', $this->deactivated);

        if ($query->execute()) {
            return true;
        }
        return false;
    }

    public static function selectUsernameOrMail($usernameOrMail)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE username = :value OR mail = :value');
        $query->bindValue(':value', $usernameOrMail);
        return $query;
    }

    public function updateLastConnection()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET lastconnection=:now WHERE username = :username');
        $query->bindValue(':now', date('Y-m-d H:i:s'));
        $query->bindValue(':username', $this->username);
        $query->execute();
    }

    public static function verifyPassword($usernameOrMail, $password): bool
    {
        $query = self::selectUsernameOrMail($usernameOrMail);
        if (!$query->execute()) {
            return false;
        }
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($password === $result['password']) {
            return true;
        }
        return false;
    }

    public static function usernameExists($username): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE  username = :username');
        $query->bindValue(':username', $username);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        return true;
    }

    public static function mailExists($mail): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE  mail = :mail');
        $query->bindValue(':mail', $mail);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        return true;
    }


}