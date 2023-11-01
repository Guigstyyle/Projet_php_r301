<?php


require_once '_assets/includes/DatabaseConnection.php';

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
     * @return void
     * @throws Exception
     * @description Used when updating the user in the database
     */
    public function __construct1($usernameOrMail)
    {
        $this->constructUserByUsername($usernameOrMail);
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
        $this->constructUserByUsername($usernameOrMail);
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
     * @param $password (Hashs it)
     * @return void
     */
    public function attributeInitialisation($username, $mail, $password): void
    {
        $this->username = $username;
        $this->mail = $mail;
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        $this->firsconnection = date('Y-m-d H:i:s');
        $this->lasconnection = date('Y-m-d H:i:s');
        $this->administrator = 0;
        $this->deactivated = 0;

        $this->registerUserToDatabase();
    }

    /**
     * @param $usernameOrMail
     * @return void
     * @throws Exception
     * @description set the attribute by using the username in a database request
     */
    public function constructUserByUsername($usernameOrMail): void
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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return string the password is hashed using PASSWORD_BCRYPT
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFrontname(): string
    {
        return $this->frontname;
    }

    /**
     * @return string
     */
    public function getFirstconnection(): string
    {
        return $this->firsconnection;
    }

    /**
     * @return string
     */
    public function getLastconnection(): string
    {
        return $this->lasconnection;
    }

    /**
     * @return int
     */
    public function getAdministrator(): int
    {
        return $this->administrator;
    }

    /**
     * @return int
     */
    public function getDeactivated(): int
    {
        return $this->deactivated;
    }
    public function getTicketsMentions(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT idticket FROM MENTIONTICKET WHERE UPPER(username) = UPPER(:username)');
        $query->bindValue(':username', $this->username);
        $query->execute();

        $tickets = array();
        while ($ticket = $query->fetch(PDO::FETCH_ASSOC)) {
            $tickets[] = new TicketModel($ticket['idticket']);
        }
        return $tickets;
    }
    public function getCommentsMentions(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT idcomment FROM MENTIONCOMMENT WHERE UPPER(username) = UPPER(:username)');
        $query->bindValue(':username', $this->username);
        $query->execute();

        $comments = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new CommentModel($comment['idcomment']);
        }
        return $comments;
    }
    public function setUsername($username){
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET username = :newusername WHERE username = :username');
        $query->bindValue(':newusername',$username);
        $query->bindValue(':username',$this->username);
        $query->execute();
        $this->username = $username;
    }

    /**
     * @param mixed $frontname
     */
    public function setFrontname($frontname): void{
        $this->frontname = $frontname;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET frontname = :newfrontname WHERE username = :username');
        $query->bindValue(':newfrontname',$frontname);
        $query->bindValue(':username',$this->username);
        $query->execute();
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->mail = $mail;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET mail = :newmail WHERE username = :username');
        $query->bindValue(':newmail',$mail);
        $query->bindValue(':username',$this->username);
        $query->execute();
    }

    public function setPassword($password){
        $this->password = $password;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET password = :newpassword WHERE username = :username');
        $query->bindValue(':newpassword',password_hash($password,PASSWORD_BCRYPT));
        $query->bindValue(':username',$this->username);
        $query->execute();
    }
    /**
     * @return bool
     * @description Change the privilege of the user an update the database
     */
    public function changeAdminState(): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET administrator = :administrator WHERE username = :username');
        if ($this->administrator) {
            $this->administrator = 0;
        } else {
            $this->administrator = 1;
        }
        $query->bindValue(':username', $this->username);
        $query->bindValue(':administrator', $this->administrator);
        return $query->execute();
    }

    /**
     * @return bool
     * @description deactivate or reactivate an account an update the database
     */
    public function changeAccountState(): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE USER SET deactivated = :deactivated WHERE username = :username');
        if ($this->deactivated) {
            $this->deactivated = 0;
        } else {
            $this->deactivated = 1;
        }
        $query->bindValue(':username', $this->username);
        $query->bindValue(':deactivated', $this->deactivated);
        return $query->execute();
    }

    /**
     * @param $usernameOrMail
     * @return false|PDOStatement
     * @description Select the username or the email to use in $this->verifyPassword.
     */
    public static function selectUsernameOrMail($usernameOrMail)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE UPPER(username) = UPPER(:value) OR UPPER(mail) = UPPER(:value)');
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
        if (password_verify($password,$result['password'])) {
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

    /**
     * @param $like
     * @return array
     * @description Get all the users that have $like in their username from the database
     */
    public static function getAllUsersLike($like)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM USER WHERE UPPER(username) LIKE UPPER(:like) ORDER BY UPPER(username)');
        $query->bindValue(':like', '%' . $like . '%');
        $query->execute();

        $users = array();
        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new UserModel($user['username']);
        }
        return $users;
    }

    /**
     * @param $username
     * @return bool
     * @description delete a user from the database based on its username
     */
    public static function DeleteFromDatabaseByUsername($username): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM USER WHERE username = :username');
        $query->bindValue(':username', $username);
        return $query->execute();
    }
}