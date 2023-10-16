<?php
require_once 'Layout.php';
class Homepage
{
    public function setContent(): string
    {
        return <<<HTML
        <h1>Bienvenue !</h1>
        <form method="post" action="index.php">
            <button type="submit" name="action" value="toLogin">Login</button>
        </form>
HTML;
    }

    public function show(): void
    {
        (new Layout('Homepage',$this->setContent()))->show();
    }
}
