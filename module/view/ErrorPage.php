<?php


require_once 'Layout.php';

class ErrorPage
{
    public function setContent($error): string
    {
        return <<<HTML
<label>Erreur {$error}</label>
HTML;
    }

    public function show($error)
    {
        (new Layout('Erreur :', $this->setContent($error)))->show();
    }
}