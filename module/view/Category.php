<?php

/**
 * @todo display tickets of the category
 */
class Category
{
    public function setContent($category): string
    {
        $name = $category->getName();
        $description = $category->getDescription();
        $id = $category->getIdCategory();

        $content = '';
        if (isset($_SESSION['suid']) and $_SESSION['user']->getAdministrator() === 1) {
            $content = '<form method="post" action="index.php">
    <input type="hidden" name="idcategory" value="' . $id . '">
    <button type="submit" name="action" value="toModifyCategory">Modifier</button>';
            $content .= '<button type="submit" name="action" value="deleteCategory">Supprimer</button> <br>
</form>';
        }
        $content .= '
<label>Nom : ' . $name . '</label><br>
<label>Description : <br>' . $description . '</label><br>';
        return $content;
    }


    public function show($category)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout($category->getname(), $this->setContent($category)))->show();
    }
}