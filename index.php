<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');

require_once 'module/controller/PostController.php';
require_once 'module/controller/AdminPageController.php';
require_once 'module/controller/AccountPageController.php';
require_once 'module/controller/CategoryController.php';
require_once 'module/controller/HomepageController.php';
require_once 'module/controller/LoginController.php';
require_once 'module/controller/RegisterController.php';
require_once 'module/controller/UserStateController.php';
require_once 'module/controller/LogoutController.php';
require_once 'module/controller/CommentController.php';
require_once 'module/controller/SearchController.php';
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
        if ($action === 'createCategory' or
            $action === 'toCreateCategory' or
            $action === 'toSearchCategory' or
            $action === 'deleteCategory' or
            $action === 'toModifyCategory' or
            $action === 'modifyCategory' or
            $action === 'showCategory') {
            (new CategoryController())->execute();
        }
        if ($action === 'toAdminPage') {
            (new AdminPageController())->execute();
        }
        if ($action === 'toSearchUser' or
            $action === 'deleteUser' or
            $action === 'changeAccountState' or
            $action === 'changeAdminState') {
            (new UserStateController())->execute();
        }
        if ($action === 'logout') {
            (new LogoutController())->execute();
        }
        if ($action === 'toPost' or
            $action === 'post' or
            $action === 'showTicket' or
            $action === 'toModifyTicket' or
            $action === 'modifyTicket' or
            $action === 'deleteTicket' or
            $action === 'toSearchTicket') {
            (new PostController())->execute();
        }
        if ($action === 'comment' or
            $action === 'modifyComment' or
            $action === 'deleteComment' or
            $action === 'toSearchComment' or
            $action === 'showComment') {
            (new CommentController())->execute();
        }
        if ($action === 'toSearch'){
            (new SearchController())->execute();
        }
        if ($action === 'toAccountPage' or
            $action === 'changeInformations' or
            $action === 'changePassword'){
            (new AccountPageController())->execute();
        }
    } else {
        (new HomepageController())->execute();
    }

} catch (Exception $exception) {
    echo $exception->getMessage();
}
/**
 * a faire :
 * mentions (mentionner d'autres users, donc changer les pages de commentaire et de billet et faire un page ou chque user voit ses mentions)
 * validation mail de creation du compte,
 * sécuriser les mots de passe,
 * mot de passe oublié,
 * faire la doc,
 * Gérer les erreurs partout
 * Une page de recherche avancé (si ya du temps)
 */