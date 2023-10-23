<?php
require_once __DIR__ . '/../model/CommentModel.php';
require_once __DIR__ . '/../view/Post.php';
class CommentController
{

    public function execute(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $action = $_POST['action'];
        if ($action === 'comment'){
            if ($comment = $this->comment()){
                $ticket = new TicketModel($_POST['idticket']);
                (new Post())->show($ticket);
            }

        }
    }
    public function comment(){
        if (!$this->validateCommentForm()){
            return false;
        }
        $user = $_SESSION['user'];
        $text = $_POST['text'];
        $idTicket = $_POST['idticket'];
        $comment = new CommentModel($user->getUsername(),$text,$idTicket);
        return $comment;

    }
    public function validateCommentForm(): bool
    {
        $text = $_POST['text'];
        if (empty($text)){
            return false;
        }
        if (!CommentModel::textLenLimit($text)){
            return false;
        }
        return true;
    }
}