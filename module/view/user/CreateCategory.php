<?php


require_once __DIR__ . '/../Layout.php';

class CreateCategory
{
    public function setContent(): string
    {
        return <<<HTML
<form method="post" action="index.php">
    <label>
        Nom de la category<br>
        <input type="text" name="categoryName" placeholder="Nom"><br>
    </label>
    <label>
        Description<br>
        <textarea name="description" placeholder="Description"></textarea><br>
    </label>
    <button type="submit" name="action" value="createCategory">Créer la catégorie</button><br>
</form>
HTML;
    }

    public function show()
    {
        (new Layout('Création de catégorie', $this->setContent()))->show();
    }
}