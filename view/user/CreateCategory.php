<?php
require_once __DIR__ . '/../Layout.php';
class CreateCategory
{
    public function setContent(): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <label>
        Nom de la category
        <input type="text" name="categoryName" placeholder="Nom">
    </label>
    <label>
        Description
        <textarea name="description" placeholder="Description"></textarea>
    </label>
    <button type="submit" name="action" value="createCategory">Créer la catégorie</button>
</form>
HTML;
    }
    public function show(){
        (new Layout('Création de catégorie',$this->setContent()))->show();
    }
}