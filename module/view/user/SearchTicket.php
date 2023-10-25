<?php


class SearchTicket

{
    public function setContent($ticket): string
    {
        $id = $ticket['idticket'];
        $title = $ticket['title'];
        if (strlen($ticket['message']) > 50) {
            $message = substr($ticket['message'], 0, 50) . '...';
        } else {
            $message = $ticket['message'];
        }
        $date = $ticket['date'];
        $username = $ticket['username'];
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
        while ($ticket = $tickets->fetch(PDO::FETCH_ASSOC))
            $content .= $this->setContent($ticket);
        $content .= '</tbody>' . PHP_EOL . '</table>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}