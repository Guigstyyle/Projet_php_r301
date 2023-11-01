<?php

require_once '_assets/includes/DatabaseConnection.php';

class CommentModel
{
    private $idComment;
    private $text;
    private $username;
    private $idTicket;
    private $date;

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

    public static function deleteComment($idcomment): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM COMMENT WHERE idcomment = :idcomment');
        $query->bindValue(':idcomment', $idcomment);
        return $query->execute();
    }

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

    }

    public function __construct3($username, $text, $idticket)
    {
        $this->constructOnNewComment($username, $text, $idticket);
    }

    public function __construct4($username, $text, $idticket, $mentions)
    {
        $this->constructOnNewComment($username, $text, $idticket);

        $this->addMentions($mentions);
    }

    /**
     * @param $username
     * @param $text
     * @param $idticket
     * @return void
     */
    public function constructOnNewComment($username, $text, $idticket): void
    {
        $this->username = $username;
        $this->text = $text;
        $this->idTicket = $idticket;
        $this->date = date('Y-m-d H:i:s');

        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO COMMENT (username,text,idticket,date) VALUES (:username,:text,:idticket,:date)');
        $query->bindValue(':username', $this->username);
        $query->bindValue(':text', $this->text);
        $query->bindValue(':idticket', $this->idTicket);
        $query->bindValue(':date', $this->date);
        $query->execute();

        $this->idComment = $pdo->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * @return mixed
     */
    public function getIdTicket()
    {
        return $this->idTicket;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE COMMENT SET text = :text WHERE idcomment = :idTicket');
        $query->bindValue(':text', $text);
        $query->bindValue(':idTicket', $this->idComment);
        $query->execute();
    }

    public function addMentions($mentions)
    {
        foreach ($mentions as $mention) {
            $this->addMention($mention);
        }
    }

    public function addMention($mention)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO MENTIONCOMMENT (username,idcomment) VALUE (:username,:idcomment)');
        $query->bindValue(':username', $mention);
        $query->bindValue(':idcomment', $this->idComment);
        $query->execute();
    }

    public function updateMentions($mentions)
    {
        $this->removeMentions();
        $this->addMentions($mentions);
    }

    public function removeMentions()
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM MENTIONCOMMENT WHERE :idcomment = idcomment');
        $query->bindValue(':idcomment', $this->idComment);
        $query->execute();
    }

    public function getMentions()
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

    public function getFrontnameByUsername(): string
    {
        $user = new UserModel($this->username);
        return $user->getFrontname();
    }

    public static function textLenLimit($text)
    {
        return (strlen($text) < 3001);
    }

    public static function getAllCommentsLike($like)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE UPPER(text) LIKE UPPER(:like) ORDER BY UPPER(text)');
        $query->bindValue(':like', '%' . $like . '%');
        $query->execute();
        $comments = array();
        while ($comment = $query->fetch(PDO::FETCH_ASSOC)) {

            $comments[] = new CommentModel($comment['idcomment']);
        }
        return $comments;
    }


}
