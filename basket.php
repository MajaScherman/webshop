<?php
session_start();
require "config.php";
require "class/db.php";
require "functions.php";

$db = new Database($config);
?>

<?php require "inc/header.php"; ?>
<h1> Basket </h1>

<?php
/*BASKET DISPLAY - Checks if basket is empty, if so then tells the user that.
   Otherwise displays the content of the basket.*/
$orderSent = false;
if( !isset($_SESSION['basket'])|| empty($_SESSION['basket']) ) {
    $status = "Basket is empty";
} else {
    $basket = $_SESSION['basket'];
    echo "This is your basket. here you can choose to buy the items currently in your basket.";
    //Open the table and its first row
    echo "<table>";
    echo "<tr>";
    echo "<td><b> Item </b></td>";
    echo "<td><b> Amount</b> </td>";
    echo "</tr>";
    //Iterates through the basket and creates a table with the content.
    foreach ($basket as $key => $value) {
        $item= $db->getItemByItemnbr($key);
        echo "<tr>";
        echo "<td>". $item["itemname"] ."</td>";
        echo "<td>". $value ."</td>";
        echo "</tr>";
    }
    //Close the table row and the table
    echo "</table>";
}

/*BUY CONTENT OF BASKET*/

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    if ( !isset( $_SESSION["username"] ) ) {
        // User is not logged in.
        $status = "Please login to proceed with order. ";
    } else {
        
        //Collects the username
        $username = $_SESSION["username"];
        //Creates a new ordernbr and checks if the ordernbr is free.
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
            if (!$basketresult)  {
                $status = "Failed to create an order";
                $orderSent = false;
            }

            //Creates ordered items in the db
            foreach ($basket as $key => $value) {
                $itemnbr = $key;
                $nbr = $value;
                $itemresult = $db->createOrderedItem($itemnbr, $ordernbr, $nbr);
                if (!$itemresult)  {
                    $status = "Failed to order item";
                    $orderSent = false;
                }
            }
            if($basketresult && $itemresult){
                $status = "Your order has been sent";
                $orderSent = true;

            }else {
                $status = $basketresult ." and ". $itemresult;
            }

        }
    }
}
if ( isset($status) ) {
    echo  $status;
}
?>
    
<?php if ( ($orderSent == false && isset($_SESSION['basket']) ) && !empty($_SESSION['basket']) ) : ?>
    
    <form action="" method="post">
        <input type="submit" value="Checkout" />
        <br />
    </form>

<?php elseif($orderSent) : ?>
    <form action="" method="post">
        <input type="button" value="View receipt" onclick="window.location.href='receipt.php'"/><br />
    </form>
<?php endif; ?>


<?php require "inc/footer.php"; ?>

