<?php

require_once '_assets/includes/DatabaseConnection.php';


class CommentModel
{
    private $idComment;
    private $text;
    private $username;
    private $idTicket;
    private $date;
    private $important;

    /**
     * @description calls the appropriate contructor based on the number of arguments.
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
     * @param $idComment
     * @return void
     * @description Used for already existing comments, when an operation on an existing comment is needed.
     */
    public function __construct1($idComment)
    {
        $this->idComment = $idComment;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE idcomment = :idcomment');
        $query->bindValue(':idcomment', $idComment);
        $query->execute();
        $comment = $query->fetch(PDO::FETCH_ASSOC);

        $this->username = $comment['username'];
        $this->text = $comment['text'];
        $this->idTicket = $comment['idticket'];
        $this->date = $comment['date'];
        $this->important = $comment['important'];

    }

    /**
     * @param $username
     * @param $text
     * @param $idticket
     * @param $important
     * @return void
     * @uses CommentModel::constructOnNewComment() to register the comment to the database and initialize attributes.
     * @description Used to construct a new comment that has no mentions
     */
    public function __construct4($username, $text, $idticket, $important)
    {
        $this->constructOnNewComment($username, $text, $idticket, $important);
    }

    /**
     * @param $username
     * @param $text
     * @param $idticket
     * @param $mentions
     * @param $important
     * @uses CommentModel::constructOnNewComment() to register the comment to the database and initialize attributes.
     * @description Used to construct a new comment that has mentions
     */
    public function __construct5($username, $text, $idticket, $mentions, $important)
    {
        $this->constructOnNewComment($username, $text, $idticket, $important);

        $this->addMentions($mentions);
    }

    /**
     * @param $username
     * @param $text
     * @param $idticket
     * @param $important
     * @return void
     * @description called when a new comment needs to be registered to the database, it also sets the attributes of the class.
     */
    public function constructOnNewComment($username, $text, $idticket, $important): void
    {
        $this->username = $username;
        $this->text = $text;
        $this->idTicket = $idticket;
        $this->date = date('Y-m-d H:i:s');
        $this->important = $important;

        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO COMMENT (username,text,idticket,date,important) VALUES (:username,:text,:idticket,:date,:important)');
        $query->bindValue(':username', $this->username);
        $query->bindValue(':text', $this->text);
        $query->bindValue(':idticket', $this->idTicket);
        $query->bindValue(':date', $this->date);
        $query->bindValue(':important', $this->important);

        $query->execute();

        $this->idComment = $pdo->lastInsertId();
    }

    /**
     * @param $idcomment
     * @return bool
     * @description deletes the comment from the database based on its id.
     */
    public static function deleteComment($idcomment): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM COMMENT WHERE idcomment = :idcomment');
        $query->bindValue(':idcomment', $idcomment);
        return $query->execute();
    }

    /**
     * @return int
     */
    public function getIdComment(): int
    {
        return $this->idComment;
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
    public function getUsername(): string
    {
        if (!isset($this->username)) {
            return 'Compte supprimé';
        }
        return $this->username;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return int
     * @description get the state of the comment important(1) or not important(0).
     */
    public function getImportant(): int
    {
        return $this->important;
    }

    /**
     * @return void
     * @description set the state of the comment to important (1).
     */
    public function setImportant()
    {
        $this->important = 1;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE COMMENT SET important = 1 WHERE idcomment = :idTicket');
        $query->bindValue(':idTicket', $this->idComment);
        $query->execute();
    }

    /**
     * @return void
     * @description set the state of the comment to not important (0).
     */
    public function setNotImportant()
    {
        $this->important = 0;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE COMMENT SET important = 0 WHERE idcomment = :idTicket');
        $query->bindValue(':idTicket', $this->idComment);
        $query->execute();
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE COMMENT SET text = :text WHERE idcomment = :idTicket');
        $query->bindValue(':text', $text);
        $query->bindValue(':idTicket', $this->idComment);
        $query->execute();
    }

    /**
     * @param $mentions
     * @return void.
     * @uses CommentModel::addMention() to add them one by one.
     * @description adds all mentions of a comment to the database.
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
        $query = $pdo->prepare('INSERT INTO MENTIONCOMMENT (username,idcomment) VALUE (:username,:idcomment)');
        $query->bindValue(':username', $mention);
        $query->bindValue(':idcomment', $this->idComment);
        $query->execute();
    }

    /**
     * @param $mentions
     * @return void
     * @uses CommentModel::removeMentions() to remove old mentions.
     * @uses CommentModel::addMentions() to add the new ones.
     * @description update all the mentions of the comment.
     */
    public function updateMentions($mentions)
    {
        $this->removeMentions();
        $this->addMentions($mentions);
    }

    /**
     * @return void
     * @description deletes all the mentions of the comment from the database.
     */
    public function removeMentions()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM MENTIONCOMMENT WHERE :idcomment = idcomment');
        $query->bindValue(':idcomment', $this->idComment);
        $query->execute();
    }

    /**
     * @return array
     * @description gets all the mentions of the comment.
     */
    public function getMentions(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM MENTIONCOMMENT WHERE idcomment = :idcomment');
        $query->bindValue(':idcomment', $this->idComment);
        $query->execute();
        $mentions = array();
        while ($mention = $query->fetch(PDO::FETCH_ASSOC)) {

            $mentions[] = $mention['username'];
        }
        return $mentions;
    }

    /**
     * @return string
     * @description gets the frontname of a user using its username.
     */
    public function getFrontnameByUsername(): string
    {
        $user = new UserModel($this->username);
        return $user->getFrontname();
    }

    /**
     * @param $text
     * @return bool
     * @description ensures that the text has a maximum length of 3000 characters.
     */
    public static function textLenLimit($text)
    {
        return (strlen($text) < 3001);
    }

    /**
     * @param $like
     * @return array
     * @description gets all the comment that have $like in them.
     */
    public static function getAllCommentsLike($like)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE UPPER(text) LIKE UPPER(:like) ORDER BY date DESC');
        $query->bindValue(':like', '%' . $like . '%');
        $query->execute();
        $comments = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)) {

            $comments[] = new CommentModel($comment['idcomment']);
        }
        return $comments;
    }


}
