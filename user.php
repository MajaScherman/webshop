<?php

require "config.php";
require "class/db.php";
require "functions.php";
session_start();

$db = new Database($config);

if ( isset($_SESSION["username"]) ) {
    $username = $_SESSION["username"];
    $user = $db->getUserByusername($username);
} else {
    // No session. Redirect.

}

?>


<?php require("inc/header.php") ?>


<h1>User Page</h1>

<?php if ( isset ($username) ) : ?>
    <h2><?= $username;  ?> </h2>
<?php endif; ?>

<?php require("inc/footer.php") ?>
