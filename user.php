<?php

require "config.php";
require "class/db.php";
require "functions.php";
session_start();

$db = new Database($config);

if ( isset($_SESSION["username"]) ) {
    $username = $_SESSION["username"];
    $user = $db->getUserByusername($username);
    $email = $user["email"];
    $givenname = $user["givenname"];
    $surname = $user["surname"];
    $homeaddress = $user["homeaddress"];
} else {
    // No session. Redirect.
    header("Location: login.php");
}

?>


<?php require("inc/header.php") ?>


<h1>User Page</h1>
<p>Welcome to your user page! Here you can find almost nothing atm...</p>

<?php if ( isset ($user) ) : ?>
    <div class="user-info">
        <ul>
            <li><strong>Username: </strong> <?= $username;  ?> </li>
            <li><strong>Email:</strong> <?= $email; ?></li>
            <li><strong>Givenname:</strong> <?= $givenname; ?></li>
            <li><strong>Surname: </strong> <?= $surname?></li>
            <li><strong>Homeaddress: </strong> <?= $homeaddress; ?></li>
        </ul>
    </div>
<?php endif; ?>
<a href="logout.php">Logout</a>

<?php require("inc/footer.php") ?>
