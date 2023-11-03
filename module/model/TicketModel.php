<?php

require_once '_assets/includes/DatabaseConnection.php';

class TicketModel
{
    private $idTicket;
    private $title;
    private $message;
    private $date;
    private $username;
    private $important;

    /**
     * @description Base constructor that calls the appropriate one.
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
     * @param $id
     * @return void
     * @description Used for already existing tickets, when an operation on an existing ticket is needed.
     */
    public function __construct1($id)
    {
        $this->idTicket = $id;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM TICKET WHERE idticket = :idticket');
        $query->bindValue(':idticket', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $this->title = $result['title'];
        $this->message = $result['message'];
        $this->date = $result['date'];
        $this->username = $result['username'];
        $this->important = $result['important'];

    }

    /**
     * @param $title
     * @param $message
     * @param $username
     * @param $important
     * @return void
     * @uses TicketModel::constructOnNewTicket() to initialize attributes and register the ticket to the database.
     * @description Called on a new ticket that has no categories nor mentions.
     */
    public function __construct4($title, $message, $username, $important)
    {
        $this->constructOnNewTicket($title, $message, $username, $important);

    }

    /**
     * @param $title
     * @param $message
     * @param $username
     * @param $categories
     * @param $important
     * @return void
     * @uses TicketModel::constructOnNewTicket() to initialize attributes and register the ticket to the database.
     * @description Called on a new ticket that has categories but no mentions.
     */
    public function __construct5($title, $message, $username, $categories, $important)
    {
        $this->constructOnNewTicket($title, $message, $username, $important);

        $this->addCategories($categories);
    }

    /**
     * @param $title
     * @param $message
     * @param $username
     * @param $categories
     * @param $mentions
     * @param $important
     * @return void
     * @uses TicketModel::constructOnNewTicket() to initialize attributes and register the ticket to the database.
     * @description Called on a new ticket that has mentions, if it has no categories call this constructor with null instead of the usual categories array.
     */
    public function __construct6($title, $message, $username, $categories, $mentions, $important)
    {

        $this->constructOnNewTicket($title, $message, $username, $important);

        if (isset($categories)) {
            $this->addCategories($categories);
        }

        $this->addMentions($mentions);
    }

    /**
     * @param $title
     * @param $message
     * @param $username
     * @param $important
     * @return void
     * @description initialize attributes and register the ticket to the database.
     */
    public function constructOnNewTicket($title, $message, $username, $important): void
    {
        $this->title = $title;
        $this->message = $message;
        $this->date = date('Y-m-d H:i:s');
        $this->username = $username;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO TICKET (title,message,date,username,important) VALUES (:title,:message,:date,:username,:important)');
        $query->bindValue(':title', $title);
        $query->bindValue(':message', $message);
        $query->bindValue(':date', $this->date);
        $query->bindValue(':username', $username);
        $query->bindValue(':important', $important);
        $query->execute();

        $query = $pdo->prepare('SELECT idticket FROM TICKET WHERE title = :title');
        $query->bindValue(':title', $title);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->idTicket = $result['idticket'];
    }

    /**
     * @param $categoryName
     * @return void
     * @description adds one category to the database.
     */
    public function addCategory($categoryName)
    {
        $pdo = DatabaseConnection::connect();
        $idCategory = CategoryModel::getCategoryIdByName($categoryName)['idcategory'];
        $query = $pdo->prepare('INSERT INTO TICKETCATEGORY (idcategory,idticket) VALUE (:idcategory,:idticket)');
        $query->bindValue(':idcategory', $idCategory);
        $query->bindValue(':idticket', $this->idTicket);
        $query->execute();
    }

    /**
     * @param $categories
     * @return void
     * @uses TicketModel::addCategory() to add them one by one.
     * @description adds all categories to the database.
     */
    public function addCategories($categories)
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * @param $categories
     * @return void
     * @uses TicketModel::removeCategories() to remove old mentions.
     * @uses TicketModel::addCategories() to add the new ones.
     * @description update all the mentions of the ticket.
     */
    public function updateCategories($categories)
    {
        $this->removeCategories();
        $this->addCategories($categories);
    }

    /**
     * @return void
     * @description deletes all the categories of the ticket from the database.
     */
    public function removeCategories()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM TICKETCATEGORY WHERE :idticket = idticket');
        $query->bindValue(':idticket', $this->idTicket);
        $query->execute();
    }

    /**
     * @param $mentions
     * @return void
     * @uses TicketModel::addMentions() to add them one by one.
     * @description adds all mentions to the database.
     */
    public function addMentions($mentions)
    {
        foreach ($mentions as $mention) {
            $this->addMention($mention);
        }
    }
    /**
     * @param $mention
     * @return void
     * @description adds one mention to the database.
     */
    public function addMention($mention)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO MENTIONTICKET (username,idticket) VALUE (:username,:idticket)');
        $query->bindValue(':username', $mention);
        $query->bindValue(':idticket', $this->idTicket);
        $query->execute();
    }

    /**
     * @param $mentions
     * @return void
     * @uses TicketModel::removeMentions() to remove old mentions.
     * @uses TicketModel::addMentions() to add the new ones.
     * @description update all the mentions of the ticket.
     */
    public function updateMentions($mentions)
    {
        $this->removeMentions();
        $this->addMentions($mentions);
    }

    /**
     * @return void
     * @description deletes all the mentions of the ticket from the database.
     */
    public function removeMentions()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM MENTIONTICKET WHERE :idticket = idticket');
        $query->bindValue(':idticket', $this->idTicket);
        $query->execute();
    }

    /**
     * @return string
     * @description gets the frontname of a user using its username.
     */
    public function getFrontnameByUsername(): string
    {
        if (!isset($this->username)) {
            return 'Compte supprimé';
        }
        $user = new UserModel($this->username);
        return $user->getFrontname();
    }

    /**
     * @return array
     * @description gets all the mentions of the ticket.
     */
    public function getMentions(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM MENTIONTICKET WHERE idticket = :idTicket');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->execute();
        $mentions = array();
        while ($mention = $query->fetch(PDO::FETCH_ASSOC)) {

            $mentions[] = $mention['username'];
        }
        return $mentions;
    }

    /**
     * @return array
     * @description gets all comments marked as important from the ticket.
     */
    public function getImportantComments(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE idticket = :idTicket AND important = 1 ORDER BY date DESC ');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->execute();
        $comments = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)) {

            $comments[] = new CommentModel($comment['idcomment']);
        }
        return $comments;
    }
    /**
     * @return array
     * @description gets all comments from the ticket.
     */
    public function getComments(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE idticket = :idTicket ORDER BY date DESC ');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->execute();
        $comments = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)) {

            $comments[] = new CommentModel($comment['idcomment']);
        }
        return $comments;
    }

    /**
     * @return array
     * @description gets all the categories of the ticket.
     */
    public function getCategories(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT idcategory FROM TICKETCATEGORY  WHERE :idticket = TICKETCATEGORY.idticket');
        $query->bindValue(':idticket', $this->idTicket);
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
     * @description ensures that the ticket title is less than 101 characters.
     */
    public static function titleLenLimit($title): bool
    {
        return strlen($title) < 101;
    }

    /**
     * @return int
     */
    public function getIdTicket(): int
    {
        return $this->idTicket;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     * @description get the state of the ticket important(1) or not important(0).
     */
    public function getImportant(): int
    {
        return $this->important;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param $title
     * @return void
     */
    public function setTitle($title): void
    {
        $this->title = $title;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET title = :title WHERE idticket = :idTicket');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->bindValue(':title', $title);
        $query->execute();
    }

    /**
     * @param $message
     * @return void
     */
    public function setMessage($message): void
    {
        $this->message = $message;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET message = :message WHERE idticket = :idTicket');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->bindValue(':message', $message);
        $query->execute();
    }

    /**
     * @return void
     * @description set the state of the ticket to important (1).
     */
    public function setImportant()
    {
        $this->important = 1;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET important = 1 WHERE idticket = :idTicket');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->execute();
    }

    /**
     * @return void
     * @description set the state of the ticket to not important (0).
     */
    public function setNotImportant()
    {
        $this->important = 0;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE TICKET SET important = 0 WHERE idticket = :idTicket');
        $query->bindValue(':idTicket', $this->idTicket);
        $query->execute();
    }

    /**
     * @param $message
     * @return bool
     * @description ensures that the ticket message is less than 3001 characters.
     */
    public static function messageLenLimit($message): bool
    {
        return strlen($message) < 2001;
    }

    /**
     * @param $idticket
     * @return bool
     * @description deletes a ticket from the database based on its id.
     */
    public static function deleteTicket($idticket): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM TICKET WHERE idticket = :idticket');
        $query->bindValue(':idticket', $idticket);
        return $query->execute();
    }

    /**
     * @param $like
     * @return array
     * @description gets all the tickets that have $like in them.
     */
    public static function getAllTicketsLike($like): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM TICKET WHERE UPPER(title) LIKE UPPER(:like) or 
                           UPPER(message) LIKE UPPER(:like) ORDER BY date DESC');
        $query->bindValue(':like', '%' . $like . '%');
        $query->execute();

        $tickets = array();
        while ($ticket = $query->fetch(PDO::FETCH_ASSOC)) {
            $tickets[] = new TicketModel($ticket['idticket']);
        }
        return $tickets;
    }

    /**
     * @return array
     * @description gets the five most recent tickets
     */
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