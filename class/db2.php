<?php
/**
 * DB functions.
 *
 * Following this guide:
 * https://code.tutsplus.com/tutorials/php-database-access-are-you-doing-it-correctly--net-25338
 */

// ONLY PLACEHOLDER, CHANGE IN FUTURE
$config = array(
    "username" => "root",
    "password" => "root",
    "database" => "practice"
);


// Connects to the db. Returns a connection object.
function connect($config){
    try {
        $username = $config["username"];
        $password = $config["password"];
        $database = $config["database"];
        $conn = new PDO("mysql:host=localhost;dbname=$database",
                                 $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        return false;
    }
}

// Returns an array of the data in specified table.
function get($table, $conn)
{
    try {
        $result = $conn->query("SELECT * FROM $table");

        if ($result->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function query($query, $bindings, $conn)
{
    try {
    $stmt = $conn->prepare($query);
    $stmt->execute($bindings);

    $results = $stmt->fetchAll();
    if ($results) {
        return results;
    } else {
        return false;
    }
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function create_user($user, $conn)
{
    $query = "INSERT INTO users VALUES(:username, :password, :email, :givenname,
:surname, :homeaddress)";

    $results = query($query, $user, $conn);
    return $results;
}

// TESTING:
$conn = connect($config);

// Create user
$new_user = array(
    ":username" => "Johnny",
    ":password" => "password",
    ":email" => "johhny@example.com",
    ":givenname" => "Johnny",
    ":surname" => "Doe",
    ":homeaddress" => "Big Street 1"
);
$result = create_user($new_user, $conn);
if ($result) {
    echo "Created new user.";
} else {
    echo "Could not create user";
}
// Print users

$users = get("users", $conn);
foreach ($users as $user)
    print_r($user);

?>
