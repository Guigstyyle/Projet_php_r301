<?php

require_once __DIR__ . '/../view/user/MentionPage.php';
require_once __DIR__ . '/../model/UserModel.php';

class MentionPageController
{
    /**
     * @return void
     * @description gets all mentions of a user and shows them on MentionPage.
     */
    public function execute(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $user = $_SESSION['user'];
        $mentionsArray = array();
        $mentionsArray['tickets'] = $user->getTicketsMentions();
        $mentionsArray['comments'] = $user->getCommentsMentions();

        (new MentionPage())->show($mentionsArray);
    }
}