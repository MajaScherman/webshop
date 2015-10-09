<?php
session_start();
require "config.php";
require "class/db.php";
require "functions.php";

$db = new Database($config);
?>

<?php require "inc/header.php"; ?>
<h1> Basket </h1>
<div class="basket center-text">
    <?php
    /*BASKET DISPLAY - Checks if basket is empty, if so then tells the user that.
       Otherwise displays the content of the basket.*/
    $orderSent = false;
    if( !isset($_SESSION['basket'])|| empty($_SESSION['basket']) ) {
        $status = "Basket is empty";
    } else {
      //Prints out a table with the content of the basket
        $basket = $_SESSION['basket'];
        echo "This is your basket. When pressing checkout below, 100 extremely
        well-trained monkeys will collect you order from our enormous warehouse
        and gently put it onto a silk pillow. Then - using magic so powerful that
        Gandalf would choke on his afternoon tea - we will magically send this to you. ";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Item</th>";
        echo "<th>Amount</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        //Iterates through the basket and fills the table with the content of the basket
        // $key is the itemnbr and $value is the amount.
        foreach ($basket as $key => $value) {
            $item= $db->getItemByItemnbr($key);
            echo "<tr>";
            echo "<td>". $item["itemname"] ."</td>";
            echo "<td>". $value ."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    /*BUY THE CONTENT OF BASKET*/

    if ( $_SERVER["REQUEST_METHOD"] == "POST") {
        if ( !isset( $_SESSION["username"] ) ) {
            // User is not logged in.
            $status = "Please login to proceed with order. ";

        // Checks that the CSRF_token is valid. This will protect against CSRF attacks.
        } elseif(!isset($_POST['CSRF_token']) || $_POST['CSRF_token'] != $_SESSION['CSRF_token']){
              $status = "POST is not valid";
        } else {

            //Collects the username
            $username = $_SESSION["username"];
            //Creates a new ordernbr and checks if the ordernbr is free.
            //The ordernbr is free if $db->getOrderByOrdernbr($ordernbr) result is empty
            $result[1] = 1;
            while (!empty($result[1])){
                $ordernbr = rand();
                $result = $db->getOrderByOrdernbr($ordernbr);
            }

            //Creates a new order in the db if the basket is not empty
            if(!isset($_SESSION['basket'])){
                $status = "The basket is empty. Please add an item to the basket before pressing the buy button";
            }else {
                $basketresult = $db->createOrder($username, $ordernbr);
                // if createOrder returns false it means that the order could not be created.
                if (!$basketresult)  {
                    $status = "Failed to create an order";
                    $orderSent = false;
                }

                //Creates ordered items in the db
                foreach ($basket as $key => $value) {
                    $itemnbr = $key;

                    // the amount is called nbr in the database
                    $nbr = $value;
                    $itemresult = $db->createOrderedItem($itemnbr, $ordernbr, $nbr);
                    // if createOrderedItem returns false it means that the orderedItem could not be created.
                    if (!$itemresult)  {
                        $status = "Failed to order item";
                        $orderSent = false;
                    }
                }
                // If both succeeds then the order was created successfully
                if($basketresult && $itemresult){
                    $status = "Your order has been sent";
                    $orderSent = true;

                }

            }
        }
    }

    ?>

<?php
// If not logged in:
if (!isset($_SESSION["username"]) ) {
    $status = "Please login or register to buy your items.";

// If logged in, order has not already been sent, basket exsists and is not empty:
// display the "CHeckout" button
}elseif(isset($_SESSION["username"]) && $orderSent == false && isset($_SESSION['basket']) && !empty($_SESSION['basket'])){
?>
    <form action="" method="post">
        <input type='hidden' name='CSRF_token' value='<?php
        echo($_SESSION['CSRF_token']) ?>' />
        <input type="submit" value="Checkout" /><br />
    </form>
<?php
// If logged in and order has been sent: display "View receipt" button
}else if(isset($_SESSION["username"]) && $orderSent) {
  ?>
  <form action="" method="post">
    <input type='hidden' name='CSRF_token' value='<?php
     echo($_SESSION['CSRF_token']) ?>' />
  <input type="button" value="View receipt" onclick="window.location.href='receipt.php'"/><br />
  </form>
  <?php
}
  //Prints the status message.
  if ( isset($status) ) {
    echo  $status ;
}
  ?>
</div>

<?php require "inc/footer.php"; ?>
