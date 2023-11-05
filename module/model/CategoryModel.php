<?php

require_once '_assets/includes/DatabaseConnection.php';
require_once __DIR__ . '/TicketModel.php';

class CategoryModel
{
    private $idCategory;
    private $name;
    private $description;

    /**
     * @description Base constructor that calls the appropriate one.
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
     * @description Used when updating the database.
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
     * @description Used when creating a new category.
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
        $this->name = $name;
        $this->description = $description;
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
     * @description update the description ,the name or both in the database.
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
     * @description Delete a category from the database based on its id.
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
     * @description ensures that the category name is less than 51 characters.
     */
    public static function nameLenLimit($name): bool
    {
        return strlen($name) < 51;
    }

    /**
     * @param $description
     * @return bool
     * @description ensures that the category description is less than 2000 characters.
     */
    public static function descriptionLenLimit($description): bool
    {
        return strlen($description) < 2001;
    }

    /**
     * @param $name
     * @return bool
     * @description Check if the category name already exist.
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
     * @return array
     * @description gets all tickets marked as important from the category.
     */
    public function getImportantTickets(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT TICKET.idticket FROM TICKETCATEGORY TC JOIN TICKET ON TC.idticket = TICKET.idticket WHERE TC.idcategory = :idCategory AND TICKET.important = 1 ORDER BY date DESC');
        $query->bindValue(':idCategory', $this->idCategory);
        $query->execute();

        $tickets = array();
        while ($ticket = $query->fetch(PDO::FETCH_ASSOC)) {
            $tickets[] = (new TicketModel($ticket['idticket']));
        }
        return $tickets;
    }

    /**
     * @return array
     * @description gets all tickets from the category.
     */
    public function getTickets(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT TICKET.idticket FROM TICKETCATEGORY TC JOIN TICKET ON TC.idticket = TICKET.idticket WHERE TC.idcategory = :idCategory ORDER BY date DESC');
        $query->bindValue(':idCategory', $this->idCategory);
        $query->execute();

        $tickets = array();
        while ($ticket = $query->fetch(PDO::FETCH_ASSOC)) {
            $tickets[] = (new TicketModel($ticket['idticket']));
        }
        return $tickets;
    }

    /**
     * @param $like
     * @return array
     * @description Get all the categories that have $like in their name from the database.
     */
    public static function getAllCategoriesLike($like): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM CATEGORY WHERE UPPER(name) LIKE UPPER(:like) or UPPER(description) LIKE UPPER(:like) ORDER BY UPPER(name)');
        $query->bindValue(':like', '%' . $like . '%');
        $query->execute();

        $categories = array();
        while ($category = $query->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new CategoryModel($category['idcategory']);
        }
        return $categories;
    }

    /**
     * @return array
     * @description get all the categories from the database.
     */
    public static function getAllcategories(): array
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT * FROM CATEGORY');
        $query->execute();

        $categories = array();
        while ($category = $query->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = (new CategoryModel($category['idcategory']));
        }
        return $categories;
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getCategoryIdByName($name)
    {
        $pdo = DatabaseConnection::connect();
        $query = $pdo->prepare('SELECT idcategory FROM CATEGORY WHERE name = :name');
        $query->bindValue(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

}
