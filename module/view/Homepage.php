<?php


require_once 'Layout.php';
require_once 'PostItemsLayout.php';

class Homepage
{
    public function setContent($fiveLast): string
    {
        $content = <<<HTML
    <section>
    <h2>Voici les 5 derniers posts :</h2>
    <ul>
HTML;
        foreach ($fiveLast as $ticket) {
            $content .= (new PostItemsLayout())->ticket($ticket,200);
        }


        $content .= <<<HTML
    </ul>
</section>
<section>
    <h2>Lites des categories</h2>
    <ul>
HTML;
        $categories = CategoryModel::getAllcategories();
        foreach ($categories as $category) {
            $content .= (new PostItemsLayout())->category($category,200);
        }
        $content .= <<<HTML
    </section>
HTML;
        return $content;
    }

    public function show($fiveLast): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        (new Layout('Page d\'accueil', $this->setContent($fiveLast)))->show();
    }
}
