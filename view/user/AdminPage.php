<?php
require_once __DIR__ . '/../Layout.php';
require_once 'CreateCategory.php';
/**
 * In this page admins can create modify or remove catergory, activate or deactivate accounts and give admin privileges to other accounts.
 */
class AdminPage
{
    /**
     * @return string
     * @todo add all management option for user accounts(delete,deactivate,and elevation) comments(delete) and tickets(delete)
     */
    public function setContent(): string
    {
        return <<<HTML
<section>
    <form method="post" action="index.php">
        <button type="submit" name="action" value="toCreateCategory">Créer une catégorie</button><br>
        <label>
            Rechercher une catégorie<br>
            <input type="text" name="categoryNameLike"><br>
        </label>
        <button type="submit" name="action" value="toSearchCategory">Rechercher une catégorie</button>
    </form>
</section>
<section>
    <form method="post" action="index.php">
        <label>
            Rechercher un utilisateur<br>
            <input type="text" name="usernameLike"><br>
        </label>
        <button type="submit" name="action" value="toSearchUser">Rechercher un utilisateur</button>
</section>
HTML;
    }
    public function show(){
        (new Layout('Admin',$this->setContent()))->show();
    }
}