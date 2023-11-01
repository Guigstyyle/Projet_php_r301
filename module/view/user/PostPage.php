<?php

class PostPage
{
    public function setContent(): string
    {
        return <<<HTML
<form class="userForm" id="postForm" method="post" action="index.php">
    <label for="title">Titre :</label>
    <input id="title" type="text" name="title" maxlength="50" placeholder="Titre">
    
    <label for="message">Message :</label>
    <textarea id="message" name="message" maxlength="3000" placeholder="Message"></textarea>
    
    
    <div>
        <label for="userSearch">Mentions:</label>
    
        <input class="searchBar" id="userSearch" type="search" name="user" placeholder="Utilisateur" autocomplete="off">
        <ul class="suggestions" id="userSuggestions">
            
        </ul>
        <label for="addedUsers">Utilisateurs mentioné :</label>
        <ul class="added" id="addedUsers">
        
        </ul>
    </div>
    <div>
    <label for="categorySearch">Catégories:</label>
        
        <input class="searchBar" id="categorySearch" type="search" name="category" placeholder="Catégorie" autocomplete="off">
        <ul id="categorySuggestions" class="suggestions">
            
        </ul>
        <label for="addedCategories">Catégories ajoutées :</label>
        <ul class="added" id="addedCategories">
        
        </ul>
    </div>
    <div class="buttonContainer" ">
        <button type="submit" name="action" value="post">Publier</button>
    </div>
</form>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/CategoryAutosuggest.js"></script>
<script src="/_assets/scripts/UserAutosuggest.js"></script>
HTML;

    }

    public function show()
    {
        (new Layout('Publication', $this->setContent()))->show();
    }
}