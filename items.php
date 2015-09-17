<?php
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST)){
    $status = "Check an item to buy.";
  }else {
    $status = "The following items has been added to your basket: ";
    foreach($_POST as $key => $value)
    {
        if (isset($key))
        {
          $status = $status . $value .", ";
        }
    }
  }
}

?>

<?php require("inc/header.php"); ?>

<h1>This is the item page.</h1>
<form action="" method="post">
<p>Please select the items you wish to buy.</p>

Java: <input type="checkbox" name="item1" value="java" /><br />

<input type="number" name="amount1" min="1" max="5">Cookie(s): 
<input type="checkbox" name="item2" value="cookie"/> <br />

<input type="submit" value="Buy" /><br />

<?php if ( isset($status) ) : ?>
<?= $status ;?>
<?php endif ?>
</form>

<?php require("inc/footer.php");
