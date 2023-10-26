<?php

class PostPage
{
    public function setContent(): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <label>
        Titre :<br>
        <input type="text" name="title" maxlength="50" placeholder="Titre"><br>
    </label>
    <label>
        Message :<br>
        <textarea name="message" maxlength="3000" placeholder="Message"></textarea><br>
    </label>
    <label>
        Catégoires:<br>
        <input id="categorySearch" type="search" name="category" placeholder="Catégorie" autocomplete="off"><br>
        <ul id="suggestions">
            
        </ul>
        <label>Catégories ajoutées :</label>
        <ul id="addedCategories">
        
        </ul>
    </label>
    <button type="submit" name="action" value="post">Publier</button>
</form>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/CategoryAutosuggest.js"></script>
HTML;

    }
    public function show()
    {
        (new Layout('Publication',$this->setContent()))->show();
    }
}