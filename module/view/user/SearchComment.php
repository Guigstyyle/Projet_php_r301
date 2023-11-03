<?php


class SearchComment

{
    public function setContent($comment): string
    {
        return (new PostItemsLayout())->comment($comment,200);
    }

    public function show($comments)
    {
        $content = '<section><ul>';
        foreach ($comments as $comment) {

            $content .= $this->setContent($comment);
        }
        $content .= '</ul></section>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}