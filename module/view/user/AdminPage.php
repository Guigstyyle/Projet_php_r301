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
     * @todo add all management option for comments(delete)
     */
    public function setContent(): string
    {
        return <<<HTML

<section>
    <form class="userForm" method="post" action="index.php">
        <div class="buttonContainer">
            <button type="submit" name="action" value="toCreateCategory">Créer une catégorie</button>
        </div>
        <label for="searchCategory">Rechercher une catégorie</label>
        <input id="searchCategory" type="search" name="categoryNameLike" placeholder="catégorie">
        <div class="buttonContainer">
            <button type="submit" name="action" value="toSearchCategory">Rechercher une catégorie</button>
        </div>
    </form>
</section>
<section>
    <form class="userForm" method="post" action="index.php">
        <label for="searchUser">Rechercher un utilisateur</label>
        <input id="searchUser" type="search" name="usernameLike" placeholder="Username">
        <div class="buttonContainer">
            <button type="submit" name="action" value="toSearchUser">Rechercher un utilisateur</button>
        </div>
    </form>
</section>
<section>
    <form class="userForm" method="post" action="index.php">
        <label for="searchTicket">Rechercher un billet</label>
        <input id="searchTicket" type="search" name="titleOrMessageLike" placeholder="Billet (titre ou message)">
        <div class="buttonContainer">
            <button type="submit" name="action" value="toSearchTicket">Rechercher un billet</button>
        </div>
    </form>
</section>
<section>
    <form class="userForm" method="post" action="index.php">
        <label for="searchComment">Rechercher un commentaire</label>
        <input id="searchComment" type="search" name="textLike" placeholder="Commentaire">
        <div class="buttonContainer">
            <button type="submit" name="action" value="toSearchComment">Rechercher un commentaire</button>
        </div>
    </form>
</section>

HTML;
    }

    public function show()
    {
        (new Layout('Admin', $this->setContent()))->show();
    }
}