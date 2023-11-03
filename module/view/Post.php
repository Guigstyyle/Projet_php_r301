<?php

class Post
{
    public function setContent($ticket, $searchedComment): string
    {
        $id = $ticket->getIdTicket();
        $title = $ticket->getTitle();
        $date = date('d/m/Y H\hi', strtotime($ticket->getDate()));
        if ($username = $ticket->getUsername()) {
            $frontname = $ticket->getFrontnameByUsername($username);
        } else {
            $frontname = 'Compte supprimé';
        }
        $message = $ticket->getMessage();
        $requestCategories = $ticket->getCategories();
        $categories = '<ul class="added">';
        if (isset($requestCategories)) {
            foreach ($requestCategories as $category) {
                $categories .= '<li>' . $category->getName() . '</li>';
            }
        }
        $categories .= '</ul>';
        $requestMentions = $ticket->getMentions();
        $mentions = '<ul class="added">';
        if (isset($requestMentions)) {
            foreach ($requestMentions as $mention) {
                $mentions .= '<li>' . $mention . '</li>';
            }
        }
        $mentions .= '</ul>';
        $comments = $ticket->getComments();
        $importantComments = $ticket->getImportantComments();

        $content = '<section class="postItems">';

        $content .=
            '<small>' . $frontname . ' - ' . $date . '</small>
<p id="ticketTitle">' . $title . '</p>

<p class="message">' . $message . '</p> 


<small class="listName">Mentions :</small>
' . $mentions . '

<small class="listName">Catégories :</small>
' . $categories;


        if (isset($_SESSION['suid']) and $_SESSION['user']->getDeactivated() === 0) {
            if ($username === $_SESSION['user']->getUsername()) {
                $content .= '<form method="post" action="index.php">
    <input type="hidden" name="idticket" value="' . $id . '">
    <button type="submit" name="action" value="toModifyTicket">Modifier</button>';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button> 
</form>';
            } elseif ($_SESSION['user']->getAdministrator() === 1) {
                $content .= '<form method="post" action="index.php">
    <input type="hidden" name="idticket" value="' . $id . '">';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button> 
</form>';
            }

        }
        $content .= '</section>';
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
        $content .= '
<section class="commentList"><h2>Commentaires importants</h2>
<ul>';

        foreach ($importantComments as $comment) {
            $content .= (new PostItemsLayout())->commentUnderTicket($comment);
        }
        $content .= '</ul>
</section>
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