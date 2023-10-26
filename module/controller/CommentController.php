<?php
require_once __DIR__ . '/../model/CommentModel.php';
require_once __DIR__ . '/../model/TicketModel.php';

require_once __DIR__ . '/../view/user/SearchComment.php';
require_once __DIR__ . '/../view/Post.php';

class CommentController
{

    public function execute()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $action = $_POST['action'];
        if ($action === 'comment') {
            if ($comment = $this->comment()) {
                $ticket = new TicketModel($_POST['idticket']);
                (new Post())->show($ticket);
            }

        }
        if ($action === 'modifyComment') {
            if ($this->modifyComment()) {
                $ticket = new TicketModel($_POST['idticket']);
                (new Post())->show($ticket);
            }
        }
        if ($action === 'deleteComment') {
            CommentModel::deleteComment($_POST['idcomment']);
            $ticket = new TicketModel($_POST['idticket']);
            (new Post())->show($ticket);
        }
        if ($action === 'toSearchComment'){
            $comments = CommentModel::getAllCommentsLike($_POST['textLike']);
            (new SearchComment())->show($comments);
        }
        if ($action === 'showComment'){
            $comment = new CommentModel($_POST['idcomment']);
            $ticket = new TicketModel($comment->getIdTicket());
            (new Post())->show($ticket,$comment);

        }
    }

    /**
     * @todo verify the form (the connected user posted)
     */
    public function modifyComment(): bool
    {
        $id = $_POST['idcomment'];
        $text = ($_POST['modifiedComment']);
        $comment = new CommentModel($id);
        $comment->setText($text);
        return true;

    }

    public function comment()
    {
        if (!$this->validateCommentForm()) {
            return false;
        }
        $user = $_SESSION['user'];
        $text = $_POST['text'];
        $idTicket = $_POST['idticket'];
        $comment = new CommentModel($user->getUsername(), $text, $idTicket);
        return $comment;

    }

    public function validateCommentForm(): bool
    {
        $text = $_POST['text'];
        if (empty($text)) {
            return false;
        }
        if (!CommentModel::textLenLimit($text)) {
            return false;
        }
        return true;
    }
}