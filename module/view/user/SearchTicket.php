<?php


class SearchTicket

{
    public function setContent($ticket): string
    {
        return (new PostItemsLayout())->ticket($ticket,200);

    }

    public function show($tickets)
    {
        $content = '<section><ul>';
        foreach ($tickets as $ticket) {
            $content .= $this->setContent($ticket);
        }
        $content .= '</ul></section>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}