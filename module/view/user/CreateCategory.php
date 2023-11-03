<?php


require_once __DIR__ . '/../Layout.php';

class CreateCategory
{
    public function setContent(): string
    {
        return <<<HTML

<form class="userForm" method="post" action="index.php">
    <label for="categoryName">Nom de la catégorie</label>
    <input id="categoryName" type="text" name="categoryName" placeholder="Nom">
    
    <label for="description">Description</label>
    <textarea id="description" name="description" placeholder="Description"></textarea>
    
    <div class="buttonContainer">
        <button type="submit" name="action" value="createCategory">Créer la catégorie</button>
    </div>
</form>

HTML;
    }

    public function show()
    {
        (new Layout('Création de catégorie', $this->setContent()))->show();
    }
}