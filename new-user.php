<?php
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $givenname = $_POST["givenname"];
    $homeaddress = $_POST["homeaddress"];
    $surname = $_POST["surname"];
    if ( empty($password) || empty($username) || empty($givenname) || empty($email) || empty($surname) || empty($homeaddress)) {
        $status = "Please fill in every field";
    } else {
        // log in user
        $status = "Thanks for registering with $username, $password, $email, $givenname, $surname and $homeaddress.";
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
    <label for="givenname">Given name :</label>
    <input type="text" name="givenname"/><br/>
    <label for="surname">Surname :</label>
    <input type="text" name="surname"/><br/>
    <label for="email">Email :</label>
    <input type="text" name="email"/><br/>
    <input type="submit" value=" Register "/><br />

    <?php if ( isset($status) ) : ?>
    <?= $status ;?>
    <?php endif ?>
  </form>
</p>



<?php require("inc/footer.php");?>
