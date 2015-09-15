<?php

echo "Im here";
/**
 * This class connects to the database.
 *
 * Creates and handles all communication with the database.
 */

class Database
{
    private $pdo;

    // ONLY PLACEHOLDER, CHANGE IN FUTURE
    private $username = "root";
    private $password = "root";
    private $database = "practice";


    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=$this->database",
                                 $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    //    Returns all users from database
    public function getUsers() {

        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();

        $users = $stmt->fetch();
        return $users;
    }

}

$db = new Database();
echo "New database <br>"
/* $users = $db->getUsers(); */
if (isset($users)) print_r($users);

?>
