<?php
require_once __DIR__ . '/../view/Search.php';
class SearchController
{
    public function execute()
    {
        $action = $_POST['action'];
        if ($action = 'toSearch') {
            $like = $_POST['searchLike'];
            $resultArray = array();
            $resultArray['categories'] = CategoryModel::getAllCategoriesLike($like);
            $resultArray['tickets'] = TicketModel::getAllTicketsLike($like);
            $resultArray['comments'] = CommentModel::getAllCommentsLike($like);
            (new Search())->show($resultArray);
        }
    }
}
