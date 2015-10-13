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


/*
   #------------------------------------------------------------------
   # Checks if email is valid
   #------------------------------------------------------------------
 */
function validEmail($email)
{
    return preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $email);
}

/*
   #------------------------------------------------------------------
   # Loads db configs from php.ini file
   #------------------------------------------------------------------
 */
function loadConfig( $vars = array() )
{
    foreach( $vars as $v ) {
        define( $v, get_cfg_var( "cfg.$v" ) );
    }
}

?>
