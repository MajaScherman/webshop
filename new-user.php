<?php
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $username = $_POST["username"];
    $homeaddress = $_POST["homeaddress"];
    if ( empty($password) || empty($username)) {
        $status = "Missing email or username.";
    } else {
        // log in user
        $status = "Thanks for registering with $username, $password and $homeaddress.";
    }
}
?>

<?php require("inc/header.php") ?>

<h3>This is where you create a new user.</h3>
<p>
  <form action="" method="post">
    <label for="username">Username :</label>
    <input type="text" name="username"/><br />
    <label for="password">Password :</label>
    <input type="password" name="password"/><br/>
    <label for="homeaddress">Home address :</label>
    <input type="text" name="homeaddress"/><br/>
    <input type="submit" value=" Register "/><br />

    <?php if ( isset($status) ) : ?>
    <?= $status ;?>
    <?php endif ?>
  </form>
</p>



<?php require("inc/footer.php");?>
