<?php

require_once __DIR__.'/../view/Homepage.php';

class HomepageController
{
    public function execute(): void
    {
        (new Homepage())->show();
    }
}