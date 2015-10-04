<?php
session_start();
require "config.php";
require "class/db.php";
require "functions.php";

$db = new Database($config);

// Creates basket array.
$basket=array();
//$_SESSION['basket']=$basket;
if ( $_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST)){
        $status = "POST is empty";
    }else {
      //Creates arrays to hold the keys and their values which the user has choosen.
      //These will later be added to
        $keys = array();
        $values = array();
        //Sets the items string which will tell the user which items he/she has added and how many to empty
        $items = "";
        //Iterates through all the items
        foreach($_POST as $key => $value)
        {
            //Picks out the items which the user has set an amount for which is not 0.
            if ($value != "0")
            {
              //Adds the item name and amount to the items string and the arrays which will be added to the basket
                $item = $db->getItemByItemnbr($key);
                $itemname = $item["itemname"];
                $items .= "</br>" . $value ." ". $itemname;
                $keys[] = $key;
                $values[] = $value;
            }
        }
        //Creates a new basket with the item names as keys and the amount as values
        $newbasket = array_combine($keys, $values);

        //Checks if the user already has a basket. If not creates an empty basket which acts as the oldbasket.
        if( isset($_SESSION['basket'])){
          //Retreives the array with the items which is currently in the basket.
          $oldbasket = $_SESSION['basket'];
          //Updates the amount for the items which already have been added to the basket
          foreach ($oldbasket as $key => $value) {
            if(array_key_exists($key,$newbasket)){
              $basket[$key] = $oldbasket[$key] + $newbasket[$key];
              unset($newbasket[$key]);
              unset($oldbasket[$key]);
            }
          }
        }else {
          $oldbasket = array();
        }
        //Adds the new items and the amount to the basket
        $basket = $basket + $oldbasket + $newbasket;
        //Updates the session variable.
        $_SESSION['basket'] = $basket;
        //Prints out the items and amount added to the basket
      if($items != ""){
          $status = 'The following items has been added to your basket: ' .$items;
        }else {
          $status = "Please select the amount of items you wish to add to your basket.";
        }
    }
}
?>

<?php require("inc/header.php"); ?>

<h1>Item</h1>
<div class="center-text">
    <form action="" method="post">
        <p>Please select the items you wish to buy.</p>

        Java(s): <select name="1">
            <?php for ($i = 0; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br />
        Cookie(s): <select name="2">
            <?php for ($i = 0; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br />
        Chocolate Cookie(s): <select name="3">
            <?php for ($i = 0; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br />

        Fairtrade Java(s): <select name="4">
            <?php for ($i = 0; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br />
        Surprise Cookie & Java set(s): <select name="5">
            <?php for ($i = 0; $i <= 5; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br />


        <input type="submit" value="Add to basket" /><br />

        <?php if ( isset($status) ) : ?>
            <?= $status ;?>
        <?php endif ?>
    </form>
    <?php if ( isset($items) ): ?>
        <p>
            Go to <a href="basket.php">basket</a> to view your ordered items.
        </p>
    <?php endif; ?>
</div>
<?php require("inc/footer.php");
