<?php
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $username = $_POST["username"];
    if ( empty($password) || empty($username)) {
        $status = "Missing email or username.";
    } else {
        // log in user
        $status = "Thanks for logging in with $username and $password.";
    }
}
?>

<?php require("inc/header.php") ?>

<h1> Login to JAVA and COOKIES awesome wepshop!!!<h1>

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

<?php require("inc/footer.php") ?>
