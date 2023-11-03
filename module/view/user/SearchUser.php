<?php


class SearchUser
{
    public function setContent($user): string
    {
        return (new PostItemsLayout())->user($user);
    }

    public function show($users)
    {
        $content = '<section><ul>';
        foreach ($users as $user) {
            $content .= $this->setContent($user);
        }
        $content .= '</ul></section>';
        (new Layout('Résultat de la recherche :', $content))->show();

    }
}