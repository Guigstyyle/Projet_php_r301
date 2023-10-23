<?php
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../view/ErrorPage.php';
require_once __DIR__ . '/../view/user/SearchUser.php';
require_once __DIR__ . '/../model/UserModel.php';

class UserStateController
{
    public function execute()
    {
        $action = $_POST['action'];
        if ($action === 'toSearchUser') {
            $users = UserModel::getAllUsersLike($_POST['usernameLike']);
            (new SearchUser())->show($users);
        }
        if ($action === 'deleteUser') {
            if ($this->deleteUser($_POST['username'])) {
                echo 'Supprimé ?';
            }
        }
        if ($action === 'changeAdminState') {
            $user = new UserModel($_POST['username']);
            if ($this->changeAdminState($user)){
                echo 'c\'est bon';
            }
        }
        if ($action === 'changeAccountState') {
            $user = new UserModel($_POST['username']);
            if ($this->changeAccountState($user)){
                echo 'c\'est bon state';
            }
        }
    }

    public function deleteUser($username): bool
    {
        try {
            if (!UserModel::DeleteFromDatabaseByUsername($username)) {
                throw new Exception('Impossible de supprimer le user.');
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }

    }

    public function changeAdminState($user)
    {
        return $user->changeAdminState();
    }
    public function changeAccountState($user)
    {
        return $user->changeAccountState();
    }

}