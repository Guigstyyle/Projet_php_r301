<?php


require_once 'Layout.php';

class Homepage
{
    public function setContent($fiveLast): string
    {
        $content = <<<HTML
<h1>Bienvenue</h1>
<section>
    <h2>Voici les 5 derniers posts :</h2>
    <table>
        <thead>
            <tr><th>Titre</th><th>Auteur</th><th>Message</th></tr>
        </thead>
        <tbody>

HTML;
        foreach ($fiveLast as $ticket) {
            $id = $ticket->getId();
            $title = $ticket->getTitle();
            if ($username = $ticket->getUsername()) {
                $frontname = $ticket->getFrontnameByUsername($username);
            } else {
                $frontname = 'Compte supprimé';
            }

            if (strlen($ticket->getMessage()) > 50) {
                $message = substr($ticket->getMessage(), 0, 50) . '...';
            } else {
                $message = $ticket->getMessage();
            }
            $content .= '
            <tr>
                <td>' . $title . '</td>
                <td>' . $frontname . '</td>
                <td>' . $message . '</td>
                <td>
                    <form method="post" action="index.php">
                        <input type="hidden" name="idticket" value="' . $id . '">
                        <button type="submit" name="action" value="showTicket">Voir</button>';
            if (isset($_SESSION['suid']) and $username === $_SESSION['user']->getUsername()) {
                $content .= '<button type="submit" name="action" value="toModifyTicket">Modifier</button>';
                $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button>';
            }
            $content .= '</form>
                </td>
            </tr>';
        }
        $content .= <<<HTML
        </tbody>
    </table>
</section>
<section>
    <h2>Lites des categories</h2>
    <table>
        <thead>
            <tr><th>Nom</th><th>Description</th></tr>
        </thead>
        <tbody>
HTML;
        $categories = CategoryModel::getAllcategories();
        foreach ($categories as $category) {
            $id = $category->getIdCategory();
            $name = $category->getName();
            if (strlen($category->getDescription()) > 50) {
                $description = substr($category->getDescription(), 0, 50) . '...';
            } else {
                $description = $category->getDescription();
            }
            $content .= '
            <tr>
                <td>' . $name . '</td>
                <td>' . $description . '</td>
                <td>
                    <form method="post" action="index.php">
                        <input type="hidden" name="idcategory" value="'.$id.'">
                        <button type="submit" name="action" value="showCategory">Voir</button>
                    </form>
                </td>
            </tr>
            ';
        }
        $content .= <<<HTML
        </tbody>
    </table>
</section>


HTML;
        return $content;
    }

    public function show($fiveLast): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        (new Layout('Homepage', $this->setContent($fiveLast)))->show();
    }
}
