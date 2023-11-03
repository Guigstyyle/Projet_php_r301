<?php


class SearchCategory

{
    public function setContent($category): string
    {
        return (new PostItemsLayout())->category($category, 200);
    }

    public function show($categories)
    {
        $content = '<section><ul>';
        foreach ($categories as $category) {
            $content .= $this->setContent($category);
        }
        $content .= '</ul></section>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}