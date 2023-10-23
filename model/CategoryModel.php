<?php

class CategoryModel
{
    private $idCategory;
    private $name;
    private $description;

    /**
     * @description Base constructor that calls the appropriate one
     */
    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        $constructor = method_exists(
            $this,
            $fn = "__construct" . $numberOfArguments
        );
        if ($constructor) {
            call_user_func_array([$this, $fn], $arguments);
        }
    }

    /**
     * @param $idCategory
     * @return void
     * @description Used when updating the database
     */
    public function __construct1($idCategory)
    {
        $this->idCategory = $idCategory;
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM CATEGORY WHERE idcategory = :idcategory');
        $query->bindValue(':idcategory', $idCategory);

        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->name = $result['name'];
        $this->description = $result['description'];
    }

    /**
     * @param $name
     * @param $description
     * @return void
     * @description Used when creating a new category
     */
    public function __construct2($name, $description)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('INSERT INTO CATEGORY (name,description) VALUES (:name,:description)');
        $query->bindValue(':name', $name);
        $query->bindValue(':description', $description);
        $query->execute();

        $query = $pdo->prepare('SELECT idcategory FROM CATEGORY WHERE name = :name');
        $query->bindValue(':name', $name);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $this->idCategory = $result['idcategory'];
    }

    /**
     * @return int
     */
    public function getIdCategory(): int
    {
        return $this->idCategory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param $description
     * @return void
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     * @description update the description ,the name or both in the database
     */
    public function updateCategory(): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('UPDATE CATEGORY SET name = :name, description = :description WHERE idcategory = :idcategory');
        $query->bindValue(':name', $this->name);
        $query->bindValue(':description', $this->description);
        $query->bindValue(':idcategory', $this->idCategory);
        return $query->execute();
    }

    /**
     * @param $id
     * @return bool
     * @description Delete a category from the database based on its id
     */
    public static function DeleteFromDatabaseById($id): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('DELETE FROM CATEGORY WHERE idcategory = :idcategory');
        $query->bindValue(':idcategory', $id);
        return $query->execute();
    }

    /**
     * @param $name
     * @return bool
     * @description ensures that the category name is less than 51 characters
     */
    public static function nameLenLimit($name): bool
    {
        return strlen($name) < 51;
    }
    /**
     * @param $description
     * @return bool
     * @description ensures that the category description is less than 2000 characters
     */
    public static function descriptionLenLimit($description): bool
    {
        return strlen($description) < 2001;
    }

    /**
     * @param $name
     * @return bool
     * @description Check if the category name already exist
     */
    public static function nameExists($name): bool
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM CATEGORY WHERE name = :name');
        $query->bindValue(':name', $name);

        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result['name'])) {
            return false;
        }
        return true;
    }

    /**
     * @param $like
     * @return false|PDOStatement
     * @description Get all the categories that have $like in their name from the database
     */
    public static function getAllCategoriesLike($like)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM CATEGORY WHERE name LIKE :like');
        $query->bindValue(':like', '%' . $like . '%');

        $query->execute();
        return $query;
    }

}
