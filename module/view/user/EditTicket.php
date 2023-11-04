<?php


require_once __DIR__ . '/../Layout.php';

class EditTicket
{
    public function setContent($ticket): string

    {
        $title = $ticket->getTitle();
        $message = $ticket->getMessage();
        $important = $ticket->getImportant();
        $id = $ticket->getIdTicket();
        $mentions = $ticket->getMentions();
        $categories = $ticket->getCategories();

        $content = '
<form class="userForm" method="post" action="index.php">
    <input type="hidden" name="idTicket" value="' . $id . '">
    <label for="title">Titre</label>
    <input id="title" type="text" name="title" placeholder="Nom" value="' . htmlspecialchars($title) . '" maxlength="100">
    
    <label for="message">Message</label>
    <textarea id="message" name="message" placeholder="Message" maxlength="3000">' . htmlspecialchars($message) . '</textarea>
   
    <label for="userSearch">Mentions:</label>
    <input class="searchBar" id="userSearch" type="search" name="user" placeholder="Utilisateur" autocomplete="off">
    <ul class="suggestions" id="userSuggestions">
        
    </ul>
    <label for="addedUsers">Utilisateurs mentioné :</label>
    <ul class="added" id="addedUsers">
    ';

        foreach ($mentions as $mention) {
            $content .= '<li>' . $mention . '<input type="hidden" name="selectedUsers[]" value="' . $mention . '"></li>';
        }
        $content .= '
    </ul>

    <label for="categorySearch">Catégories:</label>
    <input class="searchBar" id="categorySearch" type="search" name="category" placeholder="Catégorie" autocomplete="off">
    <ul class="suggestions" id="categorySuggestions">
        
    </ul>
    <label for="addedCategories">Catégories ajoutées :</label>
    <ul class="added" id="addedCategories">
    ';
        foreach ($categories as $category) {
            $content .= '<li>' . htmlspecialchars($category->getName()) . '<input type="hidden" name="selectedCategories[]" value="' . htmlspecialchars($category->getName()) . '"></li>';
        }

        $content .= '
    </ul>
    <div class="buttonContainer">';
        if ($_SESSION['user']->getAdministrator()) {
            $content .= '
        <div>
            <label for="important">Important</label>';
            if ($important) {
                $content .= '<input id="important" type="checkbox" name="important" checked>';
            } else {
                $content .= '<input id="important" type="checkbox" name="important">';
            }
            $content.='</div>';
        }
        $content .= '
        <button type="submit" name="action" value="modifyTicket">Publier</button>
    </div>
</form>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/CategoryAutosuggest.js"></script>
<script src="/_assets/scripts/UserAutosuggest.js"></script>
';
        return $content;
    }

    public function show($ticket)
    {
        (new Layout('Modification de billet', $this->setContent($ticket)))->show();
    }
}