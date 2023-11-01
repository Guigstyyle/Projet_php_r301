<?php
require_once __DIR__ . '/../view/Search.php';
class SearchController
{
    /**
     * @return void
     * @uses CategoryModel::getAllCategoriesLike()
     * @uses TicketModel::getAllTicketsLike()
     * @uses CommentModel::getAllCommentsLike()
     * @description gets all the search result and passes them to the view via an array
     */
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
