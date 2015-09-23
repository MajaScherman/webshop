<?php
require "config.php";
require "class/db.php";
require "functions.php";

session_start();


$db = new Database($config);

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $username = $_POST["username"];
    $username = htmlspecialchars($username);
    if ( empty($password) || empty($username)) {
        $status = "Missing username or password.";
    } else {
        // log in user
        if ( authenticateUser($username,$password,$db)){
            $_SESSION["username"] = $username;
            header("Location: user.php");
        }else {
            $status = "Wrong username or password";
        }
    }
}
?>

<?php require("inc/header.php") ?>

<h1> Login to JAVA and COOKIES awesome webshop!</h1>
<div class="center-text">
    <form action="" method="post">
        <label for="username">UserName :</label>
        <input type="text" name="username"/><br />
        <label for="password">Password :</label>
        <input type="password" name="password"/><br/>
        <input type="submit" value=" Submit "/><br />

        <?php if ( isset($status) ) : ?>
            <?= $status ;?>
        <?php endif ?>

    </form>
</div>
<?php require("inc/footer.php") ?>
