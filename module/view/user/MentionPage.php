<?php

class MentionPage
{
    public function setContent($mentionsArray): string
    {
        $tickets = $mentionsArray['tickets'];
        $comments = $mentionsArray['comments'];
        $content = '<h2>Billets :</h2>
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

    public function show($mentionsArray)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        (new Layout('Mentions de votre nom :', $this->setContent($mentionsArray)))->show();
    }
}
