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
     * @description Base constructor that calls the appropriate one
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

    /**
     * @param $usernameOrMail
     * @param $password
     * @return void
     * @throws Exception
     * @description Constructor used on Login.
     */
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

    /**
     * @param $username
     * @param $mail
     * @param $password
     * @description Constructor used on registration of a new user when the frontname is not provided.
     * frontname will have the value of username
     */
    public function __construct3($username, $mail, $password)
    {
        $this->frontname = $username;
        $this->attributeInitialisation($username, $mail, $password);
    }

    /**
     * @param $username
     * @param $mail
     * @param $password
     * @param $frontname
     * @description Constructor used on registration of a new user when frontname is provided
     */
    public function __construct4($username, $mail, $password, $frontname)
    {
        $this->frontname = $frontname;
        $this->attributeInitialisation($username, $mail, $password);
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

    /**
     * @param $usernameOrMail
     * @return false|PDOStatement
     * @description Select the username or the email to use in $this->verifyPassword.
     */
    public static function selectUsernameOrMail($usernameOrMail)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE username = :value OR mail = :value');
        $query->bindValue(':value', $usernameOrMail);
        return $query;
    }

    /**
     * @return void
     * @description Update the last connection to the current date.
     */
    public function updateLastConnection()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET lastconnection=:now WHERE username = :username');
        $query->bindValue(':now', date('Y-m-d H:i:s'));
        $query->bindValue(':username', $this->username);
        $query->execute();
    }

    /**
     * @param $usernameOrMail
     * @param $password
     * @return bool
     * @description Checks if $password is the correct password for the username $username.
     */
    public static function verifyPassword($usernameOrMail, $password): bool
    {
        $query = self::selectUsernameOrMail($usernameOrMail);
        if (!$query->execute()) {
            return false;
        }
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return $result;
        }
        if ($password === $result['password']) {
            return true;
        }
        return false;
    }

    /**
     * @param $username
     * @return bool
     * @description Checks if the username exists in the database
     */
    public static function usernameExists($username): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT username FROM USER WHERE username = :username');
        $query->bindValue(':username', $username);

        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result['username'])) {
            return false;
        }
        return true;
    }

    /**
     * @param $mail
     * @return bool
     * @description Checks if the email address exists in the database
     */
    public static function mailExists($mail): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE  mail = :mail');
        $query->bindValue(':mail', $mail);

        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result['mail'])) {
            return false;
        }
        return true;
    }
}