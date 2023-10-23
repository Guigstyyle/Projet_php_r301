<?php
require_once __DIR__ . '/../model/CategoryModel.php';
require_once __DIR__ . '/../view/user/CreateCategory.php';
require_once __DIR__ . '/../view/user/SearchCategory.php';
require_once __DIR__ . '/../view/user/ModifyCategory.php';
require_once __DIR__ . '/../view/ErrorPage.php';
class CategoryController
{
    public function execute(){
        $action = $_POST['action'];
        if ($action === 'toCreateCategory'){
            (new CreateCategory())->show();
        }
        if($action === 'createCategory'){
            if ($this->validateCategoryForm(null)){
                new CategoryModel($_POST['categoryName'],$_POST['description']);
                echo 'catégorie ajoutée ?';
            }
        }
        if ($action === 'toSearchCategory'){
            $categories = CategoryModel::getAllCategoriesLike($_POST['categoryNameLike']);
            (new SearchCategory())->show($categories);
        }
        if ($action === 'toModifyCategory'){
            $category = new CategoryModel($_POST['id']);
            (new ModifyCategory())->show($category->getName(),$category->getDescription(),$category->getIdCategory());
        }
        if ($action === 'modifyCategory'){
            $category = new CategoryModel($_POST['id']);
            if ($this->validateCategoryForm($category)){
                $this->modifyCategory($category);
                echo $category->getName();
            }
        }
        if ($action === 'deleteCategory'){
            if ($this->removeCategory($_POST['id'])){
                echo 'Catégory supprimée.';
            }
        }
    }
    public function validateCategoryForm($category): bool
    {
        $categoryName = $_POST['categoryName'];
        $description = $_POST['description'];
        try{
            if(empty($categoryName)){
                throw new Exception('Le nom de la catégorie est vide.');
            }
            if (!CategoryModel::nameLenLimit($categoryName)){
                throw new Exception('Le nom de la catégorie est trop long (plus de 50 caractères).');
            }
            if (!CategoryModel::descriptionLenLimit($description)){
                throw new Exception('La description de la catégorie est trop longue (plus de 2000 caractères).');
            }
            if (!isset($category) or $category->getName() !== $categoryName){
                if (CategoryModel::nameExists($categoryName)){
                    throw new Exception('Ce nom de catégorie existe déja.');
                }
            }
            return true;

        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }
    }
    public function modifyCategory($category){

        $category->setName($_POST['categoryName']);
        $category->setDescription($_POST['description']);
        $category->updateCategory();
    }
    public function removeCategory($id): bool
    {
        try {
            if(!CategoryModel::DeleteFromDatabaseById($id)){
                throw new Exception('Impossible de supprimer la catégorie.');
            }
            return true;
        } catch (Exception $exception){
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }

    }

}