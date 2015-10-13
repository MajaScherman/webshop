<?php

class Database
{
    private $conn;
    private $status_message;

    public function __construct($config)
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;
dbname=javacookie_db", $config["username"], $config["password"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e) {
            echo "Could not connect to db.";
            echo $e->getMessage();
        }
    }

    /*
       #------------------------------------------------------------------
       # Returns a table with $tablename.
       # Note that by using query the entered data needs to be escaped
       # to avoid SQL injections.
       #------------------------------------------------------------------
     */
    public function getTable($tablename)
    {
        try {
            $result = $this->conn->query("SELECT * FROM $tablename");

            return ($result->rowCount() > 0)
                ? $result
                : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
       #------------------------------------------------------------------
       # Unsafe db query method. 
       # Note that by using query the entered data needs to be escaped
       # to avoid SQL injections.
       #------------------------------------------------------------------
     */
    public function unsafeDbQuery($query)
    {
        echo $query;
        try {
            $result = $this->conn->query($query);

            return $result->fetchAll();

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    
    /*
       #------------------------------------------------------------------
       # Returns user with specified username.
       # Returns false if no user with $username was found.
       # Note that the name implies that this is unsafe. Maby it is (itis!)
       #------------------------------------------------------------------
     */
    public function unsafeGetUserByUsername($username)
    {
        $user = $this->unsafeDbQuery("SELECT * FROM users WHERE username = '" . $username . "'");
        return $user[0];
    }


    /*
       #------------------------------------------------------------------
       # Runs a prepared statement with specified bindings.
       # Should be used when something should be returned.
       # By using prepared statement there is no need to escape or quote
       # the parameters.
       # Returns an associative array.
       # Returns false if there was no data returned.
       # Saves status in status variable.
       #------------------------------------------------------------------
     */
    public function query_db($query, $bindings)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($bindings);

        $results = $stmt->fetchAll();
        $this->status_message = $stmt->errorInfo();

        return $results ? $results : false;
    }

    /*
       #------------------------------------------------------------------
       # Runs a prepared statement with specified bindings.
       # Returns true if successfull or false on failure.
       # Saves status in status variable.
       #------------------------------------------------------------------
     */
    public function insertQuery($query, $bindings)
    {
        try {
            $stmt = $this->conn->prepare($query);

            $result = $stmt->execute($bindings);
            $this->status_message = $stmt->errorInfo();

            return $result;
        } catch (Exception $e) {
            $this->status_message = $stmt->errorInfo();
            return false;
        }
    }

    /*
       #------------------------------------------------------------------
       # Returns user with specified email.
       # Returns false if no email was found.
       #------------------------------------------------------------------
     */
    public function getUserByEmail($email)
    {
        $binding = array("email" => $email);
        $user = $this->query_db("SELECT * FROM users WHERE email = :email", $binding);
        return $user[0];
    }

    /*
       #------------------------------------------------------------------
       # Returns user with specified username.
       # Returns false if no user with $username was found.
       #------------------------------------------------------------------
     */
    public function getUserByUsername($username)
    {
        $bindings = array("username" => $username);
        $user = $this->query_db("SELECT * FROM users WHERE username = :username", $bindings);
        return $user[0];
    }
    
    /*
       #------------------------------------------------------------------
       # Creates user with specified information.
       # If user could not be created, false is returned.
       #------------------------------------------------------------------
     */
    public function createUser($username, $email, $password, $givenname,
                               $surname, $homeaddress)
    {
        $bindings = array(
            "username" => $username,
            "email"    => $email,
            "password" => $password,
            "givenname" => $givenname,
            "surname" => $surname,
            "homeaddress" => $homeaddress
        );
        $query_string = "INSERT INTO users (username, password, email,
 givenname, surname, homeaddress) VALUES(:username, :password, :email,
:givenname, :surname, :homeaddress)";
        $result = $this->insertQuery($query_string, $bindings);
        return $result;
    }

    /*
       #------------------------------------------------------------------
       # Returns the status message if set, otherwise null.
       #------------------------------------------------------------------
     */
    public function getStatus()
    {
        return (isset($this->status_message))
            ? $this->status_message
            : null;
    }

    /*
       #------------------------------------------------------------------
       # Creates an order
       #------------------------------------------------------------------
     */

    public function createOrder($username, $ordernbr)
    {
        $bindings = array(
            "username" => $username,
            "ordernbr" => $ordernbr
        );
        $query_string = "INSERT INTO orders (username, ordernbr) VALUES(:username, :ordernbr)";
        $result = $this->insertQuery($query_string, $bindings);
        return $result;
    }

    /*
       #------------------------------------------------------------------
       # Creates an ordered item
       #------------------------------------------------------------------
     */

    public function createOrderedItem($itemnbr, $ordernbr, $nbr)
    {
        $bindings = array(
            "itemnbr" => $itemnbr,
            "ordernbr" => $ordernbr,
            "nbr" => $nbr
        );
        $query_string = "INSERT INTO ordered_items (itemnbr, ordernbr, nbr) VALUES(:itemnbr, :ordernbr, :nbr)";
        $result = $this->insertQuery($query_string, $bindings);
        return $result;
    }

    /*
       #------------------------------------------------------------------
       # Returns the item with the itemnbr $itemnbr.
       # Returns false if no item with that itemnbr
       #------------------------------------------------------------------
     */
    public function getItemByItemnbr($indexnbr)
    {
        $bindings = array("indexnbr" => $indexnbr);
        $item = $this->query_db("SELECT * FROM items WHERE indexnbr= :indexnbr", $bindings);
        $item = $item[0];
        return $item;
    }

    /*
       #------------------------------------------------------------------
       # Returns the order with the ordernbr $ordernbr.
       # Returns false if no order with that ordernbr.
       #------------------------------------------------------------------
     */
    public function getOrderByOrdernbr($ordernbr)
    {
        $bindings = array("ordernbr" => $ordernbr);
        $order = $this->query_db("SELECT * FROM orders WHERE ordernbr= :ordernbr", $bindings);
        $order = $order[0];
        return $order;
    }



}

// --------------- TESTING BELOW: ----------------- //
/*
   $config = array(
   "username" => "root",
   "password" => ""
   );
   $db = new Database($config);
   $result = $db->unsafeDbQuery("select * from users where username = 'nisse1'");
 */
/*
   $bind = array(
   "id" => 1
   );
   $user = $db->query("SELECT * FROM users WHERE id = :id", $bind)[0];
   var_dump($user); */
/* echo $user["username"]; */
/*
   $user = $db->getUserByEmail("bob@example.com");
   if ( $user )
   print_r($user);
   else
   echo "No user with that email."; */

/*

   $result = $db->createUser("Lina", "lina@example.com", "password123", "Lina B");

   if ($result) {
   echo "Created user.";
   } else {
   echo "Could not create user. <br>";
   if ($db->getStatus()[1] == 1062) {
   echo "Username or email already in use.";
   // ErrorCode from:
   // http://dev.mysql.com/doc/refman/5.5/en/error-messages-server.html
   }
   }  */
?>
