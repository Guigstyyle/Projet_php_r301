<?php
class Category
{
    public function setContent($category): string
    {
        $name = $category->getName();
        $description = $category->getDescription();
        $id = $category->getIdCategory();
        $tickets = $category->getTickets();

        $content = '';
        if (isset($_SESSION['suid']) and $_SESSION['user']->getAdministrator() === 1) {
            $content = '<form method="post" action="index.php">
    <input type="hidden" name="idcategory" value="' . $id . '">
    <button type="submit" name="action" value="toModifyCategory">Modifier</button>';
            $content .= '<button type="submit" name="action" value="deleteCategory">Supprimer</button><br>
</form>';
        }

        $content .= '
<label>Nom : ' . $name . '</label><br>
<label>Description : <br>' . $description . '</label><br>';
        $content .= <<<HTML
<section>
        <h2>Billets :</h2>
    <table>
        <thead>
            <tr><th>Titre</th><th>Auteur</th><th>Message</th><th>Date</th></tr>
        </thead>
        <tbody>
HTML;
        foreach ($tickets as $ticket) {
            $id = $ticket->getIdTicket();
            $title = $ticket->getTitle();
            $date = $ticket->getDate();
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
                <td>' . date('d/m/Y H\hi',strtotime($date)) . '</td>
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
HTML;
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