<?php
session_start();
require "class/db.php";

$db = new Database();
?>

<?php require "inc/header.php"; ?>
<h1> Receipt</h1>
<?php

$basket = $_SESSION['basket'];
echo "The payment has been received. The following items has been ordered and will be sent to you:";
//Open the table and its first row
echo "<table>";
echo "<tr>";
echo "<td><b> Item </b></td>";
echo "<td><b> Amount</b> </td>";
echo "</tr>";
//Iterates through the basket and creates a table with the content.
foreach ($basket as $key => $value) {
$item = $db->getItemByItemnbr($key);
  echo "<tr>";
  echo "<td>". $item["itemname"] ."</td>";
  echo "<td>". $value ."</td>";
  echo "</tr>";
}
//Close the table row and the table
echo "</table>";
//Resets the basket
$_SESSION['basket']=array();
?>
<p>
    Thanks for shopping with us. Hope your experience was as good as ours. We should do this again sometime soon. Your portrait has been printed at our office and put on our wall as 'Customer of the year'. Cheers!
</p>
<?php require "inc/footer.php"; ?>
