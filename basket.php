<?php
session_start();
?>
<?php require "inc/header.php"; ?>
<?php
if(!isset($_SESSION['basket'])){
    $status = "Basket is empty";
}else {
  //Open the table and its first row
  echo "<table>";

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

if ( isset($status) ) {
 echo  $status ;
}
?>
<?php require "inc/footer.php"; ?>
