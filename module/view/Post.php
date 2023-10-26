<?php

class Post
{
    public function setContent($ticket, $searchedComment): string
    {
        $id = $ticket->getIdTicket();
        $title = $ticket->getTitle();
        if ($username = $ticket->getUsername()) {
            $frontname = $ticket->getFrontnameByUsername($username);
        } else {
            $frontname = 'Compte supprimé';
        }
        $message = $ticket->getMessage();
        $requestCategories = $ticket->getCategories();
        $categories = '';
        if (isset($requestCategories)) {
            foreach ($requestCategories as $category) {
                $categories .= $category->getName() . '<br>';
            }
        }
        $comments = $ticket->getComments();
        $content = '';
        if (isset($_SESSION['suid']) and $_SESSION['user']->getDeactivated() === 0) {
            if ($username === $_SESSION['user']->getUsername()) {
                $content .= '<form method="post" action="index.php">
    <input type="hidden" name="idticket" value="' . $id . '">
    <button type="submit" name="action" value="toModifyTicket">Modifier</button>';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button> <br>
</form>';
            }
            if ($_SESSION['user']->getAdministrator() === 1) {
                $content .= '<form method="post" action="index.php">
    <input type="hidden" name="idticket" value="' . $id . '">';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button> <br>
</form>';
            }

        }
        $content .= '
<label>Titre : ' . $title . '</label><br>
<label>Auteur: ' . $frontname . '</label><br>
<label>Message :<br>
' . $message . ' <br>
</label>
<label>
Catégories :<br>
' . $categories . '
</label>';
        if (isset($_SESSION['suid'])) {
            $content .= '
<form method="post" action="index.php">
    <label>
        Message : <br>
        <textarea name="text" placeholder="Commentaire" maxlength="3000"></textarea><br>
        <button type="submit" name="action" value="comment">Commenter</button><br>
        <input type="hidden" name="idticket" value="' . $id . '">
    </label>
</form>';
        }
        $content .= '
<label>Commentaires :</label>
<ul>';

        if (isset($searchedComment)) {
            $content .= '<section class="comment">';
            if (isset($_SESSION['suid']) and
                $_SESSION['user']->getDeactivated() === 0 and
                ($_SESSION['user']->getUsername() === $searchedComment->getUsername() or
                    $_SESSION['user']->getAdministrator() === 1)) {
                $content .= '<form method="post" action="index.php">';
            }
            $content .= '<label>Commentaire recherché:</label><br>' . PHP_EOL .
                $searchedComment->getFrontnameByUsername() . ' :<br>' . PHP_EOL . '
<label>le : ' . date('d/m/Y H\hi', strtotime($searchedComment->getDate())) . '</label><br>
            <p>' . $searchedComment->getText() . '</p><br>';
            if (isset($_SESSION['suid']) and $_SESSION['user']->getDeactivated() === 0) {
                $content .= $this->displayButtons($searchedComment, $ticket);
            }
            $content .= '</section>';
        }
        foreach ($comments as $comment) {

            $content .= '<li class="comment">';
            if (isset($_SESSION['suid']) and
                $_SESSION['user']->getDeactivated() === 0 and
                ($_SESSION['user']->getUsername() === $comment->getUsername() or
                    $_SESSION['user']->getAdministrator() === 1)) {
                $content .= '<form method="post" action="index.php">';
            }


            $content .= $comment->getFrontnameByUsername() . ' :<br>' . PHP_EOL . '
 <label>le : ' . date('d/m/Y H\hi', strtotime($comment->getDate())) . '</label><br>
<p>' . $comment->getText() . '</p><br>';
            if (isset($_SESSION['suid']) and $_SESSION['user']->getDeactivated() === 0) {
                $content .= $this->displayButtons($comment, $ticket);
            }
            $content .= '</li>';
        }
        $content .= '</ul>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/EditComment.js"></script>';
        return $content;
    }

    public function show($ticket, $searchedComment = null)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout($ticket->getTitle(), $this->setContent($ticket, $searchedComment)))->show();
    }

    public function displayButtons($comment, $ticket): string
    {
        if ($_SESSION['user']->getUsername() === $comment->getUsername()) {
            $content = '
    <button class="modifyComment">Modifier</button><br>
    <button type="submit" name="action" value="deleteComment">Supprimer</button><br>
    <input type="hidden" name="idcomment" value="' . $comment->getIdComment() . '">
    <input type="hidden" name="idticket" value="' . $ticket->getIdTicket() . '">
</form>';

        } elseif ($_SESSION['user']->getAdministrator() === 1) {
            $content = '<button type="submit" name="action" value="deleteComment">Supprimer</button><br>
    <input type="hidden" name="idcomment" value="' . $comment->getIdComment() . '">
    <input type="hidden" name="idticket" value="' . $ticket->getIdTicket() . '">
</form>';
        }
        return $content;
    }
}