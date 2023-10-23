<?php
require_once __DIR__ . '/../Layout.php';
class ModifyCategory
{
    public function setContent($categoryName,$description,$id): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <input type="hidden" name="id" value="{$id}">
    <label>
        Nom de la category
        <input type="text" name="categoryName" placeholder="Nom" value="{$categoryName}">
    </label>
    <label>
        Description
        <textarea name="description" placeholder="Description">{$description}</textarea>
    </label>
    <button type="submit" name="action" value="modifyCategory">Modifier la catégorie</button>
</form>
HTML;
    }
    public function show($categoryName,$description,$id){
        (new Layout('Modification de catégorie',$this->setContent($categoryName,$description,$id)))->show();
    }
}