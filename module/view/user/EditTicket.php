<?php


require_once __DIR__ . '/../Layout.php';

class EditTicket
{
    public function setContent($ticket): string
    {
        $title = $ticket->getTitle();
        $message = $ticket->getMessage();
        $id = $ticket->getId();
        $categories = $ticket->getCategories();
        $content = '
<form method="post" action="index.php">
    <input type="hidden" name="id" value="'.$id.'"><br>
    <label>
        Titre<br>
        <input type="text" name="title" placeholder="Nom" value="'.$title.'" maxlength="100"><br>
    </label>
    <label>
        Message<br>
        <textarea name="message" placeholder="Message" maxlength="3000">'.$message.'</textarea><br>
    </label>
    <button type="submit" name="action" value="modifyTicket">Publier</button><br>
        <label>
        Catégoires:<br>
        <input id="categorySearch" type="search" name="category" placeholder="Catégorie"><br>
        <ul id="suggestions">
            
        </ul>
        <label>Catégories ajoutées :</label>
        <ul id="addedCategories">
        ';
        foreach ($categories as $category) {
            $content .= '<li>'.$category->getName().'<input type="hidden" name="selectedCategories[]" value="'.$category->getName().'"></li>';
        }

        $content .= '
        </ul>
    </label>
    <button type="submit" name="action" value="modifyTicket">Publier</button>
</form>
<script src="/_assets/lib/http_ajax.googleapis.com_ajax_libs_jquery_2.1.1_jquery.js"></script>
<script src="/_assets/scripts/test2.js"></script>
';
        return $content;
    }

    public function show($ticket)
    {
        (new Layout('Modification de billet', $this->setContent($ticket)))->show();
    }
}