<?php

require_once '_assets/includes/DatabaseConnection.php';
class CommentModel
{
    private $id;
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

    public function __construct1($id){
        $this->id = $id;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM COMMENT WHERE idcomment = :idcomment');
        $query->bindValue(':idcomment',$id);
        $query->execute();
        $comment = $query->fetch(PDO::FETCH_ASSOC);

        $this->username = $comment['username'];
        $this->text = $comment['text'];
        $this->idTicket = $comment['idticket'];
        $this->date = $comment['date'];

    }
    public function __construct3($username,$text,$idticket){
        $this->username = $username;
        $this->text = $text;
        $this->idTicket = $idticket;
        $this->date = date('Y-m-d H:i:s');

        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO COMMENT (username,text,idticket,date) VALUES (:username,:text,:idticket,:date)');
        $query->bindValue(':username',$this->username);
        $query->bindValue(':text',$this->text);
        $query->bindValue(':idticket',$this->idTicket);
        $query->bindValue(':date',$this->date);
        $query->execute();

        $this->id = $pdo->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE COMMENT SET text = :text WHERE idcomment = :id');
        $query->bindValue(':text',$text);
        $query->bindValue(':id',$this->id);
        $query->execute();
    }
    public function getFrontnameByUsername(): string
    {
        $user = new UserModel($this->username);
        return $user->getFrontname();
    }
    public static function textLenLimit($text){
        return (strlen($text) <3001);
    }
}
