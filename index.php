<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/HomepageController.php';
require_once 'controller/LoginController.php';
try {
    if (isset($_POST['action'])){
        if($_POST['action'] === 'login'){
            (new LoginController())->execute();
        }
        if ($_POST['action'] === 'toLogin'){
            (new LoginController())->execute();
        }
        throw new Exception('Page non existante');

    }
    else{
        (new HomepageController())->execute();
    }

}
catch (Exception $exception){
    echo $exception->getMessage();
}
