<?php


class SearchTicket

{
    public function setContent($ticket): string
    {
        $id = $ticket->getIdTicket();
        $title = $ticket->getTitle();
        if (strlen($ticket->getMessage()) > 50) {
            $message = substr($ticket->getMessage(), 0, 50) . '...';
        } else {
            $message = $ticket->getMessage();
        }
        $date = $ticket->getDate();
        $username = $ticket->getUsername();
        return <<<HTML
        <tr>
        <td>{$id}</td>
        <td>{$title}</td>
        <td>{$message}</td>
        <td>{$date}</td>
        <td>{$username}</td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="idticket" value="{$id}">
            <button type="submit" name="action" value="showTicket">voir</button> 
            <button type="submit" name="action" value="deleteTicket">Supprimer</button> 
            </form></td></tr>

HTML;

    }

    public function show($tickets)
    {
        $content = '<table>' . PHP_EOL . '    <thead>
        <tr><th>Id</th><th>title</th><th>message</th><th>date</th><th>username</th></tr>
    </thead>
    <tbody>' . PHP_EOL;
        foreach ($tickets as $ticket){
            $content .= $this->setContent($ticket);
        }
        $content .= '</tbody>' . PHP_EOL . '</table>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}