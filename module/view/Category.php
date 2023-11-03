<?php

class Category
{
    public function setContent($category): string
    {
        $tickets = $category->getTickets();
        $importantTickets = $category->getImportantTickets();
        $content = (new PostItemsLayout())->category($category);
        $content .= <<<HTML
<section>
    <h2>Billets importants :</h2>
        <ul>
HTML;
        foreach ($importantTickets as $ticket){
                $content .= (new PostItemsLayout())->ticket($ticket,200);
        }
        $content .=<<<HTML
    </ul>
</section>
<section>
    <h2>Billets :</h2>
        <ul>
HTML;
        foreach ($tickets as $ticket) {
            $content .= (new PostItemsLayout())->ticket($ticket,200);
        }
        $content .= <<<HTML
        </ul>
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