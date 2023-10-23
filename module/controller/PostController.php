<?php
require_once __DIR__ . '/../view/user/EditTicket.php';
require_once __DIR__ . '/../view/user/PostPage.php';
require_once __DIR__ . '/../model/TicketModel.php';
require_once __DIR__ . '/../model/CategoryModel.php';

require_once __DIR__ . '/../view/Post.php';

/**
 * @todo Gerer les erreurs (surtout dans modifyTicket());
 *
 */
class PostController

{
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
        if ($action === 'showTicket'){
            $ticket = new TicketModel($_POST['idticket']);
            (new Post())->show($ticket);
        }
        if ($action === 'toModifyTicket'){
            (new EditTicket())->show(new TicketModel($_POST['idticket']));
        }
        if ($action === 'modifyTicket'){
            if ($ticket = $this->modifyTicket())
                (new Post())->show($ticket);
        }
    }
    public function modifyTicket(): TicketModel
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $message = $_POST['message'];
        $ticket = new TicketModel($id);
        $ticket->setTitle($title);
        $ticket->setMessage($message);
        if (isset($_POST['selectedCategories'])){
            $ticket->updateCategories($_POST['selectedCategories']);
        }
        else{
            $ticket->removeCategories();
        }
        return $ticket;
    }
    public function post()
    {

        if ($this->validatePostForm()){
            $title = $_POST['title'];
            $message = $_POST['message'];
            $username = $_SESSION['user']->getUsername();
            if (isset($_POST['selectedCategories'])) {
                $categories = $_POST['selectedCategories'];
                $ticket = new TicketModel($title,$message,$username,$categories);
            }
            else{
                $ticket = new TicketModel($title,$message,$username);
            }
            return $ticket;
        }
        return false;
    }

    public function validatePostForm(): bool
    {
        $title = $_POST['title'];
        $message = $_POST['message'];

        try {
            if (empty($title)){
                throw new Exception('Titre vide.');
            }
            if (empty($message)){
                throw new Exception('Message vide.');
            }
            if (!TicketModel::titleLenLimit($title)) {
                throw new Exception('Le titre est trop long (plus de 100 caractères).');
            }
            if (!TicketModel::messageLenLimit($message)) {
                throw new Exception('Le message est trop long (plus de 100 caractères).');
            }
            if (isset($_POST['selectedCategories'])){
                $categories = $_POST['selectedCategories'];
                foreach ($categories as $category) {
                    if(!CategoryModel::nameExists($category)){
                        throw new Exception('Catégorie(s) invalide(s).');
                    }
                }
            }
            return true;
        } catch(Exception $exception){
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }
}