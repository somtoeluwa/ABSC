<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
// Start session
session_start();
$role = $_SESSION['sess_userrole'];
if(!isset($_SESSION['sess_email']) && ($role!="user"|| $role!="admin")){
    header('Location: index.php?err=2');
}

// include Database connection

include 'functions/functions.php';

// Page title
$page_title ="Cart";


// to prevent undefined index notice
$name = isset($_GET['assetName']) ? $_GET['assetName'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "";
$category= isset($_GET['assetCategory']) ? $_GET['assetCategory'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? $page_title : "Arduino Booking "; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-purple.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body class="w3-content">

<header class="w3-light-grey">
    <!-- top panel-->
    <div class="w3-container">
        <img id="logo" src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Home logo" style="width:30%">
        <h2 id="login_title" class="w3-xlarge"> <?php echo isset($page_title) ? $page_title : "Store Home"; ?></h2>
    </div>
    <!-- Responsive Top navigation bar -->
    <nav>
        <ul class="w3-navbar w3-theme w3-large w3-border">

            <li><a href="home.php"><i title="home" class="fa fa-home w3-large"></i></a></li>
            <li><a href="#"><i class="fa fa-search w3-large" aria-hidden="true"></i></a></li>
            <li class="w3-dropdown-hover w3-right" id="profile">
                <a class="w3-hover-purple" href="#"><i class="fa fa-user w3-large" aria-hidden="true"></i><i class="fa fa-caret-down"></i></a>
                <div class="w3-dropdown-content w3-white w3-card-2">
                    <a href="account.php?userid=<?php echo $_SESSION['userid'];?>"><?php echo $_SESSION['sess_firstname'];?>'s Profile</a>
                    <?php
                    if ($role == "admin" ) {
                        ?>
                        <a href="adminviewitems.php">Dashboard</a>
                        <?php
                    }
                    ?>
                    <a href="logout.php">Sign out</a>
                </div>
            </li>
            <li class="w3-right" <?php echo $page_title=="Cart" ? "class='active'" : ""; ?> >
                <a href="cart.php">
                    <?php
                    // count products in cart
                    $cart_count= count($_SESSION['cart_items']);
                    ?><i class="fa fa-shopping-cart w3-large"></i>
                    <span class="w3-badge" id="comparison-count"><?php echo $cart_count; ?></span>
                    item(s)
                </a>
            </li>
        </ul>
    </nav>
</header>


<!-- Main Start Item details -->

<main class="w3-padding-row">

<?php


if($action=='removed'){
    echo "<div class='alert alert-info'>";
    echo "<strong>{$name}</strong> was removed from your cart!";
    echo "</div>";
}

else if($action=='quantity_updated'){
    echo "<div class='alert alert-info'>";
    echo "<strong>{$name}</strong> quantity was updated!";
    echo "</div>";
}

if(count($_SESSION['cart_items'])>0){

    // get the product ids
    $ids = "";
    foreach($_SESSION['cart_items'] as $id=>$value){
        $ids = $ids . $id . ",";
    }

    // remove the last comma
    $ids = rtrim($ids, ',');

    ?>

   <!-- start table -->
    <form id="checkout_table" action="checkout.php" method="post" >
    <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
                      <!--Table heading-->
                        <tr>
                            <th>Asset Name</th>
                            <th>Asset Category</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
       <?php
       $query = "SELECT assetID, assetName,assetCategory,total_stock  FROM asset WHERE assetID IN ({$ids}) ORDER BY assetName";
       $stmt = $db->query( $query );
       $total_price=0;
       while ($row = $stmt->fetch_array()){
        ?>

        <tr>
            <td><a href="item.php?assetID=<?php echo $row['assetID']; ?>"><?php echo $row['assetName'];?></a></td>
            <td ><?php echo $row['assetCategory'];?></td>
            <td><input type="number" name="cart_quantity[]" value="<?php echo $_SESSION['cart_items'][$row['assetID']]['quantity'] ;?>" max="<?php echo $row['total_stock']?>">
                <input type="hidden" name="assetID[]" value="<?php echo $_SESSION['cart_items'][$row['assetID']]['assetID'];?>" />
                <input type="hidden" name="assetName[]" value="<?php echo"{$_SESSION['cart_items'][$row['assetID']]['assetName']}";?>"/></td>

            <td><a href='remove_from_cart.php?assetID=<?php echo $row['assetID']?>&assetName=<?php echo $row['assetName']?>' class='btn btn-danger'>
                    <button class='fa fa-remove remove'>Remove from cart</button></a>
            </td>
        </tr>
       <?php
                }
        ?>
        <tr>
            <td><b></b></td>
            <td></td>
            <td></td>
            <td>
                <button type="submit" name="checkout" class="confirmation">
                    <span class='fa fa-shopping-cart'></span> Checkout
                </button>
            </td>
        </tr>
    </table>
    </form>
    <?php

}

else{

    echo "<div class='alert alert-danger'>";
    echo "<strong>No products found</strong> in your cart!";
    echo "</div>";
}

?>
</main>


    <!-- Footer -->
    <footer class="w3-container w3-light-grey">
        <p> Designed by Somto Eluwa</p>
    </footer>
    <!-- -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure you want to checkout? ')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
<script type="text/javascript">
    var elems = document.getElementsByClassName('remove');
    var confirmIt = function (e) {
        if (!confirm('Do you want to remove this item? ')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

</body>
</html>

