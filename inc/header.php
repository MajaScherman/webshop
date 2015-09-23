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
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="new-user.php">Register</a></li>
        <li><a href="items.php">Items</a></li>
        <li><a href="basket.php">Basket</a></li>
    </ul>
    <?php if( isset($_SESSION["username"] ) ) : ?>
        <div class="username">
            <?= "You are logged in as: " . $_SESSION["username"]; ?>
        </div>
    <?php endif; ?>
</nav>

</br>
