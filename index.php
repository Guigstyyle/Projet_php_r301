<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Paris');

require_once 'module/controller/PostController.php';
require_once 'module/controller/AdminPageController.php';
require_once 'module/controller/CategoryController.php';
require_once 'module/controller/HomepageController.php';
require_once 'module/controller/LoginController.php';
require_once 'module/controller/RegisterController.php';
require_once 'module/controller/UserStateController.php';
require_once 'module/controller/LogoutController.php';
require_once 'module/controller/CommentController.php';
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
        $action === 'deleteComment'){
            (new CommentController())->execute();
        }
    } else {
        (new HomepageController())->execute();
    }

} catch (Exception $exception) {
    echo $exception->getMessage();
}
/**
 * Faut comprendre comment $SESSION fonctionne
 * Faut cacher ou monter les boutons en fonction du type de user connecté (pas connecté, user, admin)
 * Sur la page admin on peut chercher des category en fonction de leur nom (LIKE sql)
 * ça affichera une liste des catergory avec un bouton supprimer et un bouton modifier.
 * pareil avec les users mais avec les bouton supprimer desactiver et admin
 * Finir la doc des controllers
 * Le javascript c'est important
 */