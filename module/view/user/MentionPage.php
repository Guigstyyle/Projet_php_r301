<?php

class MentionPage
{
    public function setContent($mentionsArray): string
    {
        $tickets = $mentionsArray['tickets'];
        $comments = $mentionsArray['comments'];
        $content = '
<section>
<h2>Billets :</h2>
    <ul>';
        foreach ($tickets as $ticket) {
            $content .= (new PostItemsLayout())->ticket($ticket);
        }
        $content .= '
    </ul>
</section>
<section>
<h2>Commentaires :</h2>
    <ul>';
        foreach ($comments as $comment) {
            $content .= (new PostItemsLayout())->comment($comment);
        }
        $content .= '
    </ul>
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
