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

<div class="wrapper clear">
    <h1>User Page</h1>


    <?php if ( isset ($user) ) : ?>
        <div class="user-info">
            <ul>
                <li><strong>Username: </strong> <?= $username;  ?> </li>
                <li><strong>Email:</strong> <?= $email; ?></li>
                <li><strong>Givenname:</strong> <?= $givenname; ?></li>
                <li><strong>Surname: </strong> <?= $surname?></li>
                <li><strong>Homeaddress: </strong> <?= $homeaddress; ?></li>
            </ul>
            <ul>
                <li><a href="logout.php">Logout user</a></li>
            </ul>
            
        </div>
    <?php endif; ?>
    <div class="user-content">
        <p>Welcome <?= $givenname; ?> to your user page! </p>
        <?php
        if ( isset ($_SESSION["basket"])) {
            $basket = $_SESSION["basket"];
            $items = 0;
            foreach ($basket as $value) {
                $items += $value;
            }
        }
        ?>
        <p>
            <?php if($items == 0) : ?>
                You have no items in your basket. To add items, go to the <a href="items.php">items</a> page.
            <?php else: ?>
                You have currently <?= $items;?> item(s) in your <a href="basket.php">basket</a>.
            <?php endif; ?>
        </p>
    </div>

</div>
<?php require("inc/footer.php") ?>
