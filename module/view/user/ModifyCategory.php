<?php


require_once __DIR__ . '/../Layout.php';

class ModifyCategory
{
    public function setContent($categoryName, $description, $id): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <input type="hidden" name="idcategory" value="{$id}">
    <label>
        Nom de la categorie :<br>
        <input type="text" name="categoryName" placeholder="Nom" value="{$categoryName}" maxlength="50"><br>
    </label>
    <label>
        Description :<br>
        <textarea name="description" placeholder="Description" maxlength="3000">{$description}</textarea><br>
    </label>
    <button type="submit" name="action" value="modifyCategory">Modifier la catégorie</button>
</form>
HTML;
    }

    public function show($categoryName, $description, $id)
    {
        (new Layout('Modification de catégorie', $this->setContent($categoryName, $description, $id)))->show();
    }
}