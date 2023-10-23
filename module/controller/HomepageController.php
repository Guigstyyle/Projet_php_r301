<?php

require_once __DIR__ . '/../view/Homepage.php';
require_once __DIR__ . '/../model/TicketModel.php';
class HomepageController
{
    public function execute(): void
    {

        (new Homepage())->show(TicketModel::getFiveLast());
    }
}