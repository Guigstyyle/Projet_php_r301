<?php

class Search
{
    public function setContent($resultArray): string
    {
        $categories = $resultArray['categories'];
        $tickets = $resultArray['tickets'];
        $comments = $resultArray['comments'];
        $content = '<section>
<h2>Catégories :</h2>
<ul>';
        foreach ($categories as $category) {
            $content .= (new PostItemsLayout())->category($category,200);
        }
        $content .= '
    </ul>
</section>
<section>
<h2>Billets :</h2>
    <ul>';
        foreach ($tickets as $ticket) {
            $content .= (new PostItemsLayout())->ticket($ticket,200);
        }
        $content .= '
    </ul>
</section>
<section>
<h2>Commentaires :</h2>
    <ul>';
        foreach ($comments as $comment) {
            $content .= (new PostItemsLayout())->comment($comment,200);
        }
        $content .= '
    </ul>
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
