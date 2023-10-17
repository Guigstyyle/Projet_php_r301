<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');

require_once 'controller/HomepageController.php';
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
try {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'login' or
            $action === 'toLogin') {
            (new LoginController())->execute();
        }
        if ($action === 'toRegister' or
            $action === 'register') {
            (new RegisterController())->execute();
        }

    } else {
        (new HomepageController())->execute();
    }

} catch (Exception $exception) {
    echo $exception->getMessage();
}
