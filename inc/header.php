<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<link href="css/style.css" rel="stylesheet" type="text/css"/>
		<title>Java and Cookies!</title>
	</head>
    <body>
        <img src = "images/headerimage.jpg"; width=800px>

        <nav>
            <ul>
                <!-- Två olika menyer beroende på om man är inloggad eller ej.  -->
                <?php if ( isset($_SESSION["username"]) ) : ?>
                    <!-- Inloggad  -->
                    <li><a href="index.php">Home</a></li>
                    <li><a href="items.php">Items</a></li>
                    <li><a href="basket.php">Basket</a></li>
                    <li><a href="user.php">User Page</a></li>
                <?php else : ?>
                    <!-- Ej Inloggad -->
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="new-user.php">Register</a></li>
                    <li><a href="items.php">Items</a></li>
                    <li><a href="basket.php">Basket</a></li>
                <?php endif; ?>
            </ul>
            <!-- Visa användarnamnet under menyn -->
            <?php if( isset($_SESSION["username"] ) ) : ?>
                <div class="username">
                    <?= "You are logged in as: " . "<a href='user.php'>" .  $_SESSION["username"] . "</a>"; ?>
                </div>
            <?php endif; ?>
        </nav>
</br>
