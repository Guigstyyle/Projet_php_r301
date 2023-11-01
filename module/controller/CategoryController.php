<?php


require_once __DIR__ . '/../model/CategoryModel.php';
require_once __DIR__ . '/../view/user/CreateCategory.php';
require_once __DIR__ . '/../view/user/SearchCategory.php';
require_once __DIR__ . '/../view/user/ModifyCategory.php';
require_once __DIR__ . '/../view/user/AdminPage.php';
require_once __DIR__ . '/../view/Category.php';
require_once __DIR__ . '/../view/ErrorPage.php';

class CategoryController
{
    public function execute()
    {
        $action = $_POST['action'];
        if ($action === 'toCreateCategory') {
            (new CreateCategory())->show();
        }
        if ($action === 'createCategory') {
            if ($this->validateCategoryForm(null)) {
                $category = new CategoryModel($_POST['categoryName'], $_POST['description']);
                (new Category())->show($category);
            }
        }
        if ($action === 'toSearchCategory') {
            $categories = CategoryModel::getAllCategoriesLike($_POST['categoryNameLike']);
            (new SearchCategory())->show($categories);
        }
        if ($action === 'toModifyCategory') {
            $category = new CategoryModel($_POST['idcategory']);
            (new ModifyCategory())->show($category->getName(), $category->getDescription(), $category->getIdCategory());
        }
        if ($action === 'modifyCategory') {
            $category = new CategoryModel($_POST['idcategory']);
            if ($this->validateCategoryForm($category)) {
                $this->modifyCategory($category);
                (new Category())->show($category);
            }
        }
        if ($action === 'deleteCategory') {
            if ($this->removeCategory($_POST['idcategory'])) {
                echo 'Catégory supprimée.';
                (new AdminPage())->show();
            }
        }
        if ($action === 'showCategory') {
            $category = new CategoryModel($_POST['idcategory']);
            (new Category())->show($category);
        }

    }

    /**
     * @param $category
     * @return bool
     * @throws Exception
     * @uses CategoryModel::nameLenLimit() to check that the typed name respect the length limit
     * @uses CategoryModel::nameExists() to check that the typed name doesn't already exist
     * @uses CategoryModel::descriptionLenLimit() to check that the typed description respect the length limit
     * @description verifies if the category form is correct
     */
    public function validateCategoryForm($category): bool
    {
        $categoryName = $_POST['categoryName'];
        $description = $_POST['description'];
        try {
            if (empty($categoryName)) {
                throw new Exception('Le nom de la catégorie est vide.');
            }
            if (!CategoryModel::nameLenLimit($categoryName)) {
                throw new Exception('Le nom de la catégorie est trop long (plus de 50 caractères).');
            }
            if (!CategoryModel::descriptionLenLimit($description)) {
                throw new Exception('La description de la catégorie est trop longue (plus de 2000 caractères).');
            }
            if (!isset($category)) {
                if (CategoryModel::nameExists($categoryName)) {
                    throw new Exception('Ce nom de catégorie existe déja.');
                }
            } else {
                if ($category->getName() !== $categoryName) {
                    if (CategoryModel::nameExists($categoryName)) {
                        throw new Exception('Ce nom de catégorie existe déja.');
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
     * @param $category
     * @return void
     * @description modifies the given category based on the form. Should only be used after CategoryController::validateCategoryForm()
     */
    public function modifyCategory($category)
    {
        $category->setName($_POST['categoryName']);
        $category->setDescription($_POST['description']);
        $category->updateCategory();
    }

    /**
     * @param $id
     * @return bool
     * @description deletes the category from the database using its id
     */
    public function removeCategory($id): bool
    {
        try {
            if (!CategoryModel::DeleteFromDatabaseById($id)) {
                throw new Exception('Impossible de supprimer la catégorie.');
            }
            return true;
        } catch (Exception $exception) {
            (new ErrorPage())->show($exception->getMessage());
            return false;
        }

    }

}