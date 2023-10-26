<?php

class Search
{
    public function setContent($resultArray): string
    {
        $categories = $resultArray['categories'];
        $tickets = $resultArray['tickets'];
        $comments = $resultArray['comments'];
        $content = '<h2>Catégories :</h2>
<section>
    <table>
        <thead>
            <tr><th>Nom</th><th>Description</th></tr>
        </thead>
        <tbody>';
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
                    <form action="index.php" method="post">
                    <input type="hidden" name="idcategory" value="' . $id . '">
                    <button type="submit" name="action" value="showCategory">Voir</button>';
            if (isset($_SESSION['suid']) and $_SESSION['user']->getAdministrator() === 1) {
                $content .=
                    '                    <button type="submit" name="action" value="toModifyCategory">Modifier</button> 
                    <button type="submit" name="action" value="deleteCategory">Supprimer</button>';

            }
            $content .= '
                    </form>
                </td>
            </tr>';
        }
        $content .= '
        </tbody>
    </table>
</section>
<h2>Billets :</h2>
<section>
    <table>
        <thead>
            <tr><th>Titre</th><th>Auteur</th><th>Message</th><th>Date</th></tr>
        </thead>
        <tbody>';
        foreach ($tickets as $ticket) {
            $id = $ticket->getIdTicket();
            $title = $ticket->getTitle();
            $frontname = $ticket->getFrontnameByUsername();
            $date = $ticket->getDate();
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
                <td>' . date('d/m/Y H\hi', strtotime($date)) . '</td>
                <td>
                    <form action="index.php" method="post">
                    <input type="hidden" name="idticket" value="' . $id . '">
                    <button type="submit" name="action" value="showTicket">Voir</button>
                    </form>
                </td>
            </tr>';
        }
        $content .= '
        </tbody>
    </table>
</section>
<h2>Commentaires :</h2>
<section>
    <table>
        <thead>
            <tr><th>Auteur</th><th>Text</th><th>Date</th></tr>
        </thead>';
        foreach ($comments as $comment) {

            $idTicket = $comment->getIdTicket();
            $idComment = $comment->getIdComment();
            $frontname = $comment->getFrontnameByUsername();
            $date = $comment->getDate();
            if (strlen($comment->getText()) > 50) {
                $text = substr($comment->getText(), 0, 50) . '...';
            } else {
                $text = $comment->getText();
            }
            $content .= '
            <tr>
                <td>' . $frontname . '</td>
                <td>' . $text . '</td>
                <td>' . date('d/m/Y H\hi', strtotime($date)) . '</td>
                <td>
                    <form action="index.php" method="post">
                    <input type="hidden" name="idcomment" value="' . $idComment . '">
                    <button type="submit" name="action" value="showComment">Voir</button> 
                    </form>
                </td>
            </tr>';
        }
        $content .= '
        </tbody>
    </table>
</section>';
        return $content;
    }

    public function show($resultArray)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout('Resultat de la recherche :', $this->setContent($resultArray)))->show();
    }
}
