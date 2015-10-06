<?php

// This page is only used for logging out user and then sending to home page.

session_start();

session_destroy();

$_SESSION = array();

// delete session data

header("Location: index.php");

?>