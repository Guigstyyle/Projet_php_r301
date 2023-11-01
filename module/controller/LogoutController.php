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

    /**
     * @return void
     * @description logs out the current user, unsets $_session to delete the suid and destroys the session.
     */
    public function logout()
    {
        session_start();
        unset($_SESSION);
        session_destroy();

    }
}