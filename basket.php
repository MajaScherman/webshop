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
if(!isset($_SESSION['basket'])|| empty($_SESSION['basket'])){
    $status = "Basket is empty";
}else {
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
    }

    //Creates ordered items in the db
    foreach ($basket as $key => $value) {
      $itemnbr = $key;
      $nbr = $value;
      $itemresult = $db->createOrderedItem($itemnbr, $ordernbr, $nbr);
      if (!$itemresult)  {
        $status = "Failed to order item";
      }
    }
    if($basketresult && $itemresult){
      $status = "Your order has been sent";
    }else {
      $status = $basketresult ." and ". $itemresult;
    }
    //Resets the basket
    $_SESSION['basket']=array();
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
