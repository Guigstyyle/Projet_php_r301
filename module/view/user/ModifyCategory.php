<?php


require_once __DIR__ . '/../Layout.php';

class ModifyCategory
{
    public function setContent($categoryName, $description, $id): string
    {
        return <<<HTML
    <form class="userForm" method="post" action="index.php">
        <input type="hidden" name="idcategory" value="{$id}">
        <label for="categoryName">Nom de la categorie :</label>
        <input id="categoryName" type="text" name="categoryName" placeholder="Nom" value="{$categoryName}" maxlength="50">
        
        <label for="description">Description :</label>
        <textarea id="description" name="description" placeholder="Description" maxlength="3000">{$description}</textarea>
       
        <div class="buttonContainer">
            <button type="submit" name="action" value="modifyCategory">Modifier la catégorie</button>
        </div>
    </form>
HTML;
    }

    public function show($categoryName, $description, $id)
    {
        (new Layout('Modification de catégorie', $this->setContent($categoryName, $description, $id)))->show();
    }
}