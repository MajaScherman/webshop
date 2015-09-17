<?php

/*
   #------------------------------------------------------------------
   # Controlls the specified credentials with the db.
   # The specified password is hashed and checked against stored
   # password (via password_verify()).
   #------------------------------------------------------------------
 */
function authenticateUser($username, $password, $db)
{
    $user = $db->getUserByUsername($username);
    if ($user) {
        // User exists
        if (password_verify($password, $user["password"]))  {
            // Login correct
            return true;
        } else {
            // Wrong password
            return false;
        }
    } else {
        // User doesn't exist
        return false;
    }
}


?>
