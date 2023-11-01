<?php


require_once __DIR__ . '/../view/user/AdminPage.php';
require_once __DIR__ . '/../view/ErrorPage.php';

class AdminPageController
{
    public function execute(): void
    {
        session_start();
        try {
            if (isset($_SESSION['suid'])) {
                if ($_SESSION['user']->getAdministrator() === 1) {
                    (new AdminPage())->show();
                }
            } else {
                throw new Exception('Accès refusé.');
            }
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
        }
    }
}