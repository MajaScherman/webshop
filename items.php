<?php

session_start();

if ( $_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST)){
    $status = "POST is empty";
  }else {
    $items = "";
    foreach($_POST as $key => $value)
    {
        if ($value != "0")
        {
          $items .= "</br>" . $value ." ". $key;
        }
    }
    if($items != ""){
      $status = "The following items has been added to your basket:" ." ". $items;
    }else {
      $status = "Please select the amount of items you wish to add to your basket.";
    }

  }
}

?>

<?php require("inc/header.php"); ?>

<h1>This is the item page.</h1>
<form action="" method="post">
<p>Please select the items you wish to buy.</p>

Java(s): <select name="Javas">
    <?php for ($i = 0; $i <= 5; $i++) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php endfor; ?>
</select><br />
Cookie(s): <select name="Cookies">
    <?php for ($i = 0; $i <= 5; $i++) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
    <?php endfor; ?>
</select><br />


<input type="submit" value="Add to basket" /><br />

<?php if ( isset($status) ) : ?>
<?= $status ;?>
<?php endif ?>
</form>

<?php require("inc/footer.php");
