<?php

// This page is only used for logging out user and then sending to home page.

session_start();

session_destroy();

$_SESSION = array();

// delete cookies...

header("Location: index.php");

?>