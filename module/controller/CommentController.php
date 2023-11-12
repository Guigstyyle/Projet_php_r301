<?php
require_once __DIR__ . '/../model/CommentModel.php';
require_once __DIR__ . '/../model/TicketModel.php';

require_once __DIR__ . '/../view/user/SearchComment.php';
require_once __DIR__ . '/../view/Post.php';

class CommentController
{

    /**
     * @throws Exception
     */
    public function execute()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $action = $_POST['action'];
        if ($action === 'comment') {
            if ($this->comment()) {
                $ticket = new TicketModel($_POST['idticket']);
                (new Post())->show($ticket);
            }

        }
        if ($action === 'modifyComment') {
            if ($this->modifyComment()) {
                $ticket = new TicketModel($_POST['idticket']);
                $comment = new CommentModel($_POST['idcomment']);
                (new Post())->show($ticket,$comment);
            }
        }
        if ($action === 'deleteComment') {
            if ($this->deleteComment()) {
                $ticket = new TicketModel($_POST['idticket']);
                (new Post())->show($ticket);
            }
        }
        if ($action === 'toSearchComment') {
            $comments = CommentModel::getAllCommentsLike($_POST['textLike']);
            (new SearchComment())->show($comments);
        }
        if ($action === 'showComment') {
            $comment = new CommentModel($_POST['idcomment']);
            $ticket = new TicketModel($comment->getIdTicket());
            (new Post())->show($ticket, $comment);

        }
        if ($action === 'makeImportant'){
            $comment = new CommentModel($_POST['idcomment']);
            $ticket = new TicketModel($comment->getIdTicket());
            if ($comment->getImportant()){
                $comment->setNotImportant();
            } else {
                $comment->setImportant();
            }
            (new Post())->show($ticket, $comment);
        }
    }

    /**
     * @return CommentModel|false
     * @throws Exception
     * @uses CommentController::validateCommentForm() to make sure there no error in the form.
     * @description Create the right comment model object that registers it to the database.
     */
    public function comment()
    {
        $text = $_POST['text'];
        if (!$this->validateCommentForm($text)) {
            return false;
        }
        $user = $_SESSION['user'];
        $idTicket = $_POST['idticket'];

        $important = isset($_POST['important']) ? 1 : 0;

        $mentions = null;
        if (isset($_POST['selectedUsers'])) {
            $mentions = $_POST['selectedUsers'];
        }
        if (isset($mentions)) {
            $comment = new CommentModel($user->getUsername(), $text, $idTicket, $mentions, $important);
        } else {
            $comment = new CommentModel($user->getUsername(), $text, $idTicket, $important);
        }
        return $comment;

    }

    /**
     * @return bool
     * @throws Exception
     * @uses CommentController::verifyAuthor() to make sure a user didn't modify the form to edit another user's comment.
     * @uses CommentController::validateCommentForm() to make sure there no error in the form.
     * @description Create a comment model using its id and updates the text and mentions of the comment.
     */
    public function modifyComment(): bool
    {
        $text = ($_POST['modifiedComment']);
        if (!$this->validateCommentForm($text)) {
            return false;
        }
        $id = $_POST['idcomment'];
        $comment = new CommentModel($id);
        try {
            if (!$this->verifyAuthor($comment)) {
                throw new Exception('Vous ne pouvez pas modifier les commentaires des autres.');
            }

        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
        $important = isset($_POST['important']) ? 1 : 0;
        if ($important === 1){
            $comment->setImportant();
        }
        else{
            $comment->setNotImportant();
        }
        $comment->setText($text);
        if (isset($_POST['selectedUsers'])) {
            $comment->updateMentions($_POST['selectedUsers']);
        } else {
            $comment->removeMentions();
        }
        return true;

    }

    /**
     * @return bool
     * @throws Exception
     * @uses CommentController::verifyAuthor() to check that the deletion is made by the author.
     * @uses CommentModel::deleteComment() to delete the comment from the database.
     * @description deletes the comment from the database.
     */
    private function deleteComment(): bool
    {
        try {
            if (!$this->verifyAuthor(new CommentModel($_POST['idcomment'])) && $_SESSION['user']->getAdministrator() === 0) {
                throw new Exception('Vous ne pouvez pas supprimer les commentaires des autres');
            }
            CommentModel::deleteComment($_POST['idcomment']);
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @param $text
     * @return bool
     * @throws Exception
     * @description Checks that the text is not empty or larger than 3000 characters.
     */
    public function validateCommentForm($text): bool
    {
        try {
            if (empty($text)) {
                throw new Exception('Vous ne pouvez pas poster un commentaire vide.');
            }
            if (!CommentModel::textLenLimit($text)) {
                throw new Exception('Le commentaire est trop long (plus de 3000 caractères).');
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @param $comment
     * @return bool
     * @description ensures that author of the comment is the one that is modifying or deleting it.
     */
    public function verifyAuthor($comment): bool
    {
        if ($comment->getUsername() !== $_SESSION['user']->getUsername()) {
            return false;
        }
        return true;
    }
}
