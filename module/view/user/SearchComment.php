<?php


class SearchComment

{
    public function setContent($comment): string
    {
        $idTicket = $comment->getIdTicket();
        $idComment = $comment->getIdComment();
        if (strlen($comment->getText()) > 50) {
            $text = substr($comment->getText(), 0, 50) . '...';
        } else {
            $text = $comment->getText();
        }
        $date = $comment->getDate();
        $username = $comment->getUsername();
        return <<<HTML
        <tr>
        <td>{$idComment}</td>
        <td>{$idTicket}</td>
        <td>{$username}</td>
        <td>{$text}</td>
        <td>{$date}</td>
        <td><form action="index.php" method="post">
            <input type="hidden" name="idticket" value="{$idTicket}">
            <input type="hidden" name="idcomment" value="{$idComment}">
            <button type="submit" name="action" value="showComment">voir</button> 
            <button type="submit" name="action" value="deleteComment">Supprimer</button> 
            </form></td></tr>

HTML;

    }

    public function show($comments)
    {
        $content = '<table>' . PHP_EOL . '    <thead>
        <tr><th>IdComment</th><th>IdTicket</th><th>Username</th><th>Text</th><th>date</th></tr>
    </thead>
    <tbody>' . PHP_EOL;
        foreach ($comments as $comment) {

            $content .= $this->setContent($comment);
        }
        $content .= '</tbody>' . PHP_EOL . '</table>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}