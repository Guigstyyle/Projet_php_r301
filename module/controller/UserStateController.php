<?php


require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../view/ErrorPage.php';
require_once __DIR__ . '/../view/user/AdminPage.php';
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
                (new AdminPage())->show();
            }
        }
        if ($action === 'changeAdminState') {
            $user = new UserModel($_POST['username']);
            if ($this->changeAdminState($user)) {
                (new AdminPage())->show();
            }
        }
        if ($action === 'changeAccountState') {
            $user = new UserModel($_POST['username']);
            if ($this->changeAccountState($user)) {
                (new AdminPage())->show();
            }
        }
    }

    /**
     * @param $username
     * @return bool
     * @description deletes a user from the database
     */
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

    /**
     * @param $user
     * @return bool
     * @description  promotes or downgrades a user to admin or from admin
     */
    public function changeAdminState($user): bool
    {
        return $user->changeAdminState();
    }

    /**
     * @param $user
     * @return bool
     * @description activates or deactivates an account
     */
    public function changeAccountState($user): bool
    {
        return $user->changeAccountState();
    }

}