<?php

require_once __DIR__.'/../view/Homepage.php';

class AdminPageController
{
    public function execute(): void
    {
        (new AdminPage())->show();
    }
}