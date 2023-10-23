<?php

require_once '_assets/includes/DatabaseConnection.php';

class TicketModel
{
    private $id;
    private $title;
    private $message;
    private $date;
    private $username;

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

    public function __construct1($id)
    {
        $this->id = $id;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM TICKET WHERE idticket = :idticket');
        $query->bindValue(':idticket', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $this->title = $result['title'];
        $this->message = $result['message'];
        $this->date = $result['date'];
        $this->username = $result['username'];
    }

    public function __construct3($title, $message, $username)
    {
        $this->constructOnNewTicket($title, $message, $username);

    }

    public function __construct4($title, $message, $username, $categories)
    {
        $this->constructOnNewTicket($title, $message, $username);

        $this->addCategories($categories);
    }

    /**
     * @param $title
     * @param $message
     * @param $username
     * @return void
     */
    public function constructOnNewTicket($title, $message, $username): void
    {
        $this->title = $title;
        $this->message = $message;
        $this->date = date('Y-m-d H:i:s');
        $this->username = $username;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO TICKET (title,message,date,username) VALUES (:title,:message,:date,:username)');
        $query->bindValue(':title', $title);
        $query->bindValue(':message', $message);
        $query->bindValue(':date', $this->date);
        $query->bindValue(':username', $username);
        $query->execute();

        $query = $pdo->prepare('SELECT idticket FROM TICKET WHERE title = :title');
        $query->bindValue(':title', $title);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->id = $result['idticket'];
    }

    public function addCategory($categoryName)
    {
        $pdo = DatabaseConnection::connect();
        $idCategory = CategoryModel::getCategoryIdByName($categoryName)['idcategory'];
        $query = $pdo->prepare('INSERT INTO TICKETCATEGORY (idcategory,idticket) VALUE (:idcategory,:idticket)');
        $query->bindValue(':idcategory', $idCategory);
        $query->bindValue(':idticket', $this->id);
        $query->execute();
    }

    public function addCategories($categories)
    {
        $pdo = DatabaseConnection::connect();
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    public function updateCategories($categories)
    {
        $this->removeCategories();
        $this->addCategories($categories);
    }

    public function removeCategories()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM TICKETCATEGORY WHERE :idticket = idticket');
        $query->bindValue(':idticket', $this->id);
        $query->execute();
    }

    public function getFrontnameByUsername(): string
    {
        $user = new UserModel($this->username);
        return $user->getFrontname();
    }
    public function getComments(){
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE idticket = :id');
        $query->bindValue(':id',$this->id);
        $query->execute();
        $comments[] = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)){
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getCategories()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT CATEGORY.idcategory,CATEGORY.name,CATEGORY.description 
FROM TICKETCATEGORY 
    JOIN CATEGORY ON CATEGORY.idcategory = TICKETCATEGORY.idcategory WHERE :idticket = TICKETCATEGORY.idticket');
        $query->bindValue(':idticket', $this->id);
        $query->execute();
        $categories = array();
        while ($category = $query->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new CategoryModel($category['idcategory']);
        }
        return $categories;
    }

    /**
     * @param $title
     * @return bool
     * @description ensures that the ticket title is less than 101 characters
     */
    public static function titleLenLimit($title): bool
    {
        return strlen($title) < 101;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET title = :title WHERE idticket = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':title', $title);
        $query->execute();
    }

    public function setMessage($message): void
    {
        $this->message = $message;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET message = :message WHERE idticket = :id');
        $query->bindValue(':id', $this->id);
        $query->bindValue(':message', $message);
        $query->execute();
    }


    /**
     * @param $message
     * @return bool
     * @description ensures that the ticket message is less than 3001 characters
     */
    public static function messageLenLimit($message): bool
    {
        return strlen($message) < 2001;
    }

    public static function getFiveLast(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM TICKET ORDER BY date DESC LIMIT 5');
        $query->execute();
        $fiveLast = array();
        while ($ticket = $query->fetch(PDO::FETCH_ASSOC)) {
            $fiveLast[] = (new TicketModel($ticket['idticket']));
        }
        return $fiveLast;

    }
}