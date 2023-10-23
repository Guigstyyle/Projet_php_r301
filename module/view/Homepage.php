<?php


require_once 'Layout.php';

class Homepage
{
    public function setContent($ticket): string
    {
        $id = $ticket->getId();
        $title = $ticket->getTitle();
        if ($username = $ticket->getUsername()){
            $frontname = $ticket->getFrontnameByUsername($username);
        }
        else{
            $frontname = 'Compte supprimé';
        }

        if (strlen($ticket->getMessage()) > 50) {
            $message = substr($ticket->getMessage(), 0, 50) . '...';
        } else {
            $message = $ticket->getMessage();
        }
        $content ='
            <tr>
                <td>'.$title.'</td>
                <td>'.$frontname.'</td>
                <td>'.$message.'</td>
                <td>
                    <form method="post" action="index.php">
                        <input type="hidden" name="idticket" value="'.$id.'">
                        <button type="submit" name="action" value="showTicket">Voir</button>';
        if (isset($_SESSION['suid']) and $username === $_SESSION['user']->getUsername()){
        $content .= '<button type="submit" name="action" value="toModifyTicket">Modifier</button>';
        $content .= '<button type="submit" name="action" value="deleteTicket">Supprimer</button>';
    }
        $content .= '</form>
                </td>
            </tr>';
        return $content;
    }

    public function show($fiveLast): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $content = <<<HTML
<h1>Bienvenue</h1>
<section>
    <label>Voici les 5 derniers posts :</label><br>
    <table>
        <thead>
            <tr><th>Titre</th><th>Auteur</th><th>Message</th></tr>
        </thead>
        <tbody>

HTML;
        foreach ($fiveLast as $ticket){
            $content .= $this->setContent($ticket);
        }
        $content .= <<<HTML

        </tbody>
    </table>
</section>
HTML;

        (new Layout('Homepage',$content))->show();
    }
}
