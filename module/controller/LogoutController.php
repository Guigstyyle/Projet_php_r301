<?php

require_once __DIR__ . '/../view/Homepage.php';

class LogoutController
{
    public function execute()
    {
        if ($_POST['action'] === 'logout') {
            $this->logout();
            (new Homepage())->show(TicketModel::getFiveLast());
        }

    }

    public function logout()
    {
        session_start();
        unset($_SESSION);
        session_destroy();

    }
}