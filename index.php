<?php
session_start();

//Assigns a new CSRF_token 
$randomtoken = base64_encode( openssl_random_pseudo_bytes(32));
$_SESSION["CSRF_token"] = $randomtoken;
?>

<?php require "inc/header.php"; ?>


<h1>
Welcome to Java && Cookies!
</h1>

<p>
We at Java && Cookies wish you welcome to our absolutely safe webshop!
Here you can buy a cup of java and relax with some cookies.
We wish you a nice secure day!
</p>

<?php require "inc/footer.php"; ?>
