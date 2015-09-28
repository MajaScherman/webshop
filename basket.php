<?php
session_start();
require "config.php";
require "class/db.php";
require "functions.php";

$db = new Database($config);
?>

<?php require "inc/header.php"; ?>

<?php
/*BASKET DISPLAY - Checks if basket is empty, if so then tells the user that.
  Otherwise displays the content of the basket.*/
if(!isset($_SESSION['basket'])){
    $status = "Basket is empty";
}else {
  //Open the table and its first row
  echo "<table>";
  //Iterates through the basket and creates a table with the content.
  $basket = $_SESSION['basket'];
  foreach ($basket as $key => $value) {
    echo "<tr>";
    echo "<td>". $key ."</td>";
    echo "<td>". $value ."</td>";
    echo "</tr>";
  }
  //Close the table row and the table
  echo "</table>";
}

/*BUY CONTENT OF BASKET*/

if ( $_SERVER["REQUEST_METHOD"] == "POST") {

  //Creates a new order
  $username = $_SESSION["username"];
  $ordernbr = 1; //METHOD FOR SETTING UNIQUE ORDER NBR?

  if(!isset($_SESSION['basket'])){
    $status = "The basket is empty. Please add an item to the basket before pressing the buy button";
  }else {
    $result = $db->createOrder($username, $ordernbr);
    if ($result)  {
        // Mostly for debugging, change later?
        echo "Order has been created.";
    } else {
        echo "Order failed. ";
    }
    foreach ($basket as $key => $value) {
      $itemnbr = $key;
      //ordernbr already set earlier
      $nbr = $value;
      $result = $db->createOrderedItem($itemnbr, $ordernbr, $nbr);
      if ($result)  {
          // Mostly for debugging, change later?
          echo "Item has been added to order.";
      } else {
          echo "Item could not be added to order.";
      }
    }
    $status = "Your order has been sent";
  }
}
if ( isset($status) ) {
 echo  $status ;
}
?>
<form action="" method="post">
<input type="submit" value="Buy" /><br />
</form>
<?php require "inc/footer.php"; ?>
