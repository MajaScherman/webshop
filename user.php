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
        <p>Welcome to your user page! Here you can find almost nothing atm...</p>
        <p>Some dummy text:</p>
        <p>
            Quam quisque id diam vel quam elementum pulvinar etiam non
            quam lacus suspendisse faucibus interdum posuere lorem
            ipsum dolor sit amet, consectetur adipiscing. Amet tellus
            cras adipiscing enim eu turpis?  Neque, vitae tempus quam
            pellentesque nec nam aliquam sem et! Hendrerit lectus a
            molestie lorem ipsum dolor sit amet, consectetur
            adipiscing elit ut aliquam, purus sit amet luctus
            venenatis, lectus!  Nunc vel risus commodo viverra
            maecenas accumsan, lacus vel facilisis volutpat, est velit
            egestas dui, id ornare arcu odio ut sem nulla pharetra
            diam! Nibh sit amet commodo nulla facilisi?  Vulputate
            sapien nec sagittis aliquam malesuada bibendum arcu. Id
            cursus metus aliquam eleifend mi in nulla posuere
            sollicitudin aliquam ultrices sagittis orci, a scelerisque
            purus semper eget duis at tellus.
        </p>

    </div>

</div>
<?php require("inc/footer.php") ?>
