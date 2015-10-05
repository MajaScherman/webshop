<?php
session_start();

require "config.php";
require "class/db.php";
require "functions.php";

$db = new Database($config);

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $username = htmlspecialchars($_POST["username"]);
    $email = $_POST["email"];
    $givenname = htmlspecialchars($_POST["givenname"]);
    $homeaddress = htmlspecialchars($_POST["homeaddress"]);
    $surname = htmlspecialchars($_POST["surname"]);
    if ( empty($password) || empty($username) || empty($givenname) ||
         empty($email) || empty($surname) || empty($homeaddress)) {
        $status = "Please fill in every field";
    } else if ( !validEmail($email)) {
        $status = "Please enter a valid email. ";
    } else if (!preg_match("%^[A-Za-z0-9-_]{3,100}$%", $_POST["password"])) {
        $status = "The username can only consist of letters, numbers, - and _.
      The password should be at least 3 charachers long.";
    } else {
        //Register user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $result = $db->createUser($username, $email, $hashed_password, $givenname,
                                  $surname, $homeaddress);
        if ($result)  {
            // User created successfully.
            $status = "Thanks for registering with $username and $homeaddress.";
        } else {
            $status = "Username or email already exists. ";
        }
    }
}

?>

<?php require("inc/header.php") ?>

<h1>Register</h1>
<div class="center-text">
    <p>
        <form action="" method="post">
            <table class="table-register" >
                <tr>
                    <td>
                        <label for="username">Username :</label>
                    </td>
                    <td>
                        <input type="text" name="username"/><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password :</label>
                    </td>
                    <td>
                        <input type="password" name="password"/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="homeaddress">Home address :</label>
                    </td>
                    <td>
                        <input type="text" name="homeaddress"/><br/>
                    </td>
                </tr>
                <tr>
                <td>
                    <label for="givenname">Given name :</label>
                </td>
                <td>
                    <input type="text" name="givenname"/><br/>
                </td>
                </tr>
                <tr>
                    <td>
                        <label for="surname">Surname :</label>
                    </td>
                    <td>
                        <input type="text" name="surname"/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email :</label>
                    </td>
                    <td>
                        <input type="text" name="email"/><br/>
                    </td>
                </tr>
            </table>

            <input type="submit" value=" Register "/><br />
            
            <?php if ( isset($status) ) : ?>
                <?= $status ;?>
            <?php endif ?>
        </form>
</p>
</div>


<?php require("inc/footer.php");?>
