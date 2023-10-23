<?php

/**
 * @todo Trouver un moyen de recuperer le frontname dans un commentaire
 */
class Post
{
    public function setContent($ticket): string
    {
        $id = $ticket->getId();
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
        if (isset($_SESSION['suid']) and $username === $_SESSION['user']->getUsername()) {
            $content .= '<form method="post" action="index.php">
    <input type="hidden" name="idticket" value="' . $id . '">
    <button type="submit" name="action" value="toModifyTicket">Modifier</button>';
            $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button> <br>
</form>';
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
</form>
<label>Commentaires :</label>
<ul>';
        }
            foreach ($comments as $comment) {

                $content .= '<li>
Auteur :' . $comment->getFrontnameByUsername() . '<br>
Commentaire :'.$comment->get.'
</li>';
            }


        return $content;


    }

    public function show($ticket)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout($ticket->getTitle(), $this->setContent($ticket)))->show();
    }
}