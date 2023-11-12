<?php
require_once __DIR__ . '/../view/user/EditTicket.php';
require_once __DIR__ . '/../view/user/PostPage.php';
require_once __DIR__ . '/../model/TicketModel.php';
require_once __DIR__ . '/../model/CategoryModel.php';
require_once __DIR__ . '/../view/user/SearchTicket.php';
require_once __DIR__ . '/../view/Post.php';

class PostController

{
    /**
     * @throws Exception
     */
    public function execute()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $action = $_POST['action'];
        if ($action === 'toPost') {
            (new PostPage())->show();
        }
        if ($action === 'post') {
            if ($ticket = $this->post()) {
                (new Post())->show($ticket);
            }
        }
        if ($action === 'showTicket') {
            $ticket = new TicketModel($_POST['idticket']);
            (new Post())->show($ticket);
        }
        if ($action === 'toModifyTicket') {
            (new EditTicket())->show(new TicketModel($_POST['idticket']));
        }
        if ($action === 'modifyTicket') {
            if ($ticket = $this->modifyTicket())
                (new Post())->show($ticket);
        }
        if ($action === 'deleteTicket') {
            if ($this->deleteTicket()) {
                (new Homepage())->show(TicketModel::getFiveLast());
            }
        }
        if ($action === 'toSearchTicket') {
            $tickets = TicketModel::getAllTicketsLike($_POST['titleOrMessageLike']);
            (new SearchTicket())->show($tickets);
        }
    }

    /**
     * @return false|TicketModel
     * @throws Exception
     * @uses PostController::validatePostForm()
     * @description validate the form and create the appropriate TicketModel that will save the ticket to the database.
     */
    public function post()
    {
        if ($this->validatePostForm()) {
            $title = $_POST['title'];
            $message = $_POST['message'];
            $username = $_SESSION['user']->getUsername();
            if (isset($_POST['important'])) {
                $important = 1;
            } else {
                $important = 0;
            }
            if (isset($_POST['selectedCategories'])) {
                $categories = $_POST['selectedCategories'];
                if (!isset($_POST['selectedUsers'])) {
                    $ticket = new TicketModel($title, $message, $username, $categories, $important);
                } else {
                    $mentionedUsers = $_POST['selectedUsers'];
                    $ticket = new TicketModel($title, $message, $username, $categories, $mentionedUsers, $important);
                }
            } else {
                if (isset($_POST['selectedUsers'])) {
                    $mentionedUsers = $_POST['selectedUsers'];
                    $ticket = new TicketModel($title, $message, $username, null, $mentionedUsers, $important);
                } else {
                    $ticket = new TicketModel($title, $message, $username, $important);
                }
            }
            return $ticket;
        }
        return false;
    }


    /**
     * @return false|TicketModel
     * @throws Exception
     * @uses PostController::validatePostForm()
     * @uses PostController::verifyAuthor()
     * @description Modifies an existing ticket model that updates the database.
     */
    public function modifyTicket()
    {
        if (!$this->validatePostForm()) {
            return false;
        }
        $id = $_POST['idTicket'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        $ticket = new TicketModel($id);

        try {
            if (!$this->verifyAuthor($ticket)) {
                throw new Exception('Vous ne pouvez pas modifier les billes des autres.');
            }
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
        $ticket->setTitle($title);
        $ticket->setMessage($message);
        if (isset($_POST['important'])) {
            $ticket->setImportant();
        } else {
            $ticket->setNotImportant();
        }
        if (isset($_POST['selectedUsers'])) {
            $ticket->updateMentions($_POST['selectedUsers']);
        } else {
            $ticket->removeMentions();
        }
        if (isset($_POST['selectedCategories'])) {
            $ticket->updateCategories($_POST['selectedCategories']);
        } else {
            $ticket->removeCategories();
        }
        return $ticket;
    }


    /**
     * @return bool
     * @throws Exception
     * @uses PostController::verifyAuthor()
     * @description deletes a ticket from the database after verifying the action is taken by the author.
     */
    public function deleteTicket(): bool
    {
        $ticket = new TicketModel($_POST['idticket']);
        try {
            if ((!$this->verifyAuthor($ticket)) && ($_SESSION['user']->getAdministrator() === 0)) {
                throw new Exception('Vous ne pouvez pas supprimer les billets des autres.');
            }
            TicketModel::deleteTicket($_POST['idticket']);
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @return bool
     * @throws Exception
     * @uses TicketModel::titleLenLimit() to check that the length of the title is lower than 100 characters.
     * @uses TicketModel::messageLenLimit() to check that the length of the message is lower than 3000 characters.
     * @uses CategoryModel::nameExists() to check if all categories exists
     * @description Checks if the form is valid.
     */
    public function validatePostForm(): bool
    {
        $title = $_POST['title'];
        $message = $_POST['message'];

        try {
            if (empty($title)) {
                throw new Exception('Titre vide.');
            }
            if (empty($message)) {
                throw new Exception('Message vide.');
            }
            if (!TicketModel::titleLenLimit($title)) {
                throw new Exception('Le titre est trop long (plus de 100 caractères).');
            }
            if (!TicketModel::messageLenLimit($message)) {
                throw new Exception('Le message est trop long (plus de 3000 caractères).');
            }
            if (isset($_POST['selectedCategories'])) {
                $categories = $_POST['selectedCategories'];
                foreach ($categories as $category) {
                    if (!CategoryModel::nameExists($category)) {
                        throw new Exception('Catégorie(s) invalide(s).');
                    }
                }
            }
            if (isset($_POST['selectedUsers'])) {
                $users = $_POST['selectedUsers'];
                foreach ($users as $username) {
                    if (!UserModel::usernameExists($username)) {
                        throw new Exception('Utilisateur(s) introuvable(s)');
                    }
                }
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }

    /**
     * @param $ticket
     * @return bool
     * @description ensures that author of the ticket is the one that is modifying or deleting it.
     */
    public function verifyAuthor($ticket): bool
    {
        if ($ticket->getUsername() !== $_SESSION['user']->getUsername()) {
            return false;
        }
        return true;
    }
}
