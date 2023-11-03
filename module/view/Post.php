<?php

class Post
{
    public function setContent($ticket, $searchedComment): string
    {
        $id = $ticket->getIdTicket();
        $comments = $ticket->getComments();
        $importantComments = $ticket->getImportantComments();


        $content = (new PostItemsLayout())->ticket($ticket);

        if (isset($_SESSION['suid'])) {
            $content .= '
<form class="userForm" method="post" action="index.php">
    <label for="message">Message :</label>
    <textarea id="message" name="text" placeholder="Commentaire" maxlength="3000"></textarea>
    <input type="hidden" name="idticket" value="' . $id . '">

    <label for="userSearch">Mentions:</label>
    <input class="searchBar" id="userSearch" type="search" name="user" placeholder="Utilisateur" autocomplete="off">
    <ul class="suggestions" id="userSuggestions">
        
    </ul>
    <label for="addedUsers">Utilisateurs mentioné :</label>
    <ul class="added" id="addedUsers">
    
    </ul>
    <div class="buttonContainer">';
            if ($_SESSION['user']->getAdministrator()) {
                $content .= '
        <div>
            <label for="important">Important</label>
            <input id="important" type="checkbox" name="important">
        </div>';
            }
            $content .= '
        <button type="submit" name="action" value="comment">Commenter</button>
    </div>
</form>';
        }
        if (isset($searchedComment)) {
            $content .= '
<section class="commentList"><h2>Commentaire recherché</h2>
<ul class="commentList">';
            $content .= (new PostItemsLayout())->commentUnderTicket($searchedComment, 1);
            $content .= '
</ul></section>';
        }


        if (!empty($importantComments)) {
            $content .= '
<section class="commentList"><h2>Commentaires importants</h2>
<ul>';
            foreach ($importantComments as $comment) {
                $content .= (new PostItemsLayout())->commentUnderTicket($comment);
            }
            $content .= '</ul>
</section>';
        }

        $content .= '
<section class="commentList"><h2>Commentaires</h2>
<ul>';

        foreach ($comments as $comment) {

            $content .= (new PostItemsLayout())->commentUnderTicket($comment);
        }
        $content .= '</ul>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/EditComment.js"></script>
<script src="/_assets/scripts/UserAutosuggest.js"></script>';
        return $content;
    }

    public function show($ticket, $searchedComment = null)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout($ticket->getTitle(), $this->setContent($ticket, $searchedComment)))->show();
    }

}