


<?php

//Start session
session_start();
$role = $_SESSION['sess_userrole'];
if(!isset($_SESSION['sess_email']) && ($role!="user"|| $role!="admin")){
    header('Location: index.php?err=2');
}

// include Database connection
include 'functions/functions.php';

//Get the Asset
$assetID = $_GET['assetID'];

// Page title
$page_title ="Asset Details";


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? $page_title : "Arduino component booking System"; ?> - Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-purple.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body class="w3-content">
<!-- Header start -->
<header class="w3-light-grey">
    <!-- top panel-->
    <div class="w3-container">
        <img id="logo" src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Home logo" style="width:30%">
        <marquee><h2 id="login_title" class="w3-xlarge"><?php echo isset($page_title) ? $page_title : "Store Home"; ?> </h2></marquee>
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
<main>
    <div class="row">
        <ul id="sidenavbar" class=" w3-ul w3-card-2 w3-theme-l4  w3-hoverable col-2" >
            <!-- Navbar header-->
            <li><a href="home.php" class="w3-border-bottom"><h3>Components</h3></a></li>

            <!-- Navbar content -->

            <li><a href="home.php?assetCategory=Actuators">Actuators</a></li>
            <li><a href="home.php?assetCategory=Connectors">Connectors</a></li>
            <li><a href="home.php?assetCategory=LCD_Matrix">LCD & Matrix</a></li>
            <li><a href="home.php?assetCategory=Passive_Active">Passive & Active</a></li>
            <li><a href="home.php?assetCategory=Sensors">Sensors</a></li>
        </ul>


        <div id="itemdetails" class="col-10 col-m-10 w3-container">


            <?php

            if ($_GET['assetID']){
                $sql_asset = "SELECT * FROM asset WHERE assetID = '$assetID' ";
            }
            else{
                $sql_asset = "SELECT * FROM asset";
            }
            $result2 =  $db->query($sql_asset);
            while ($row = $result2->fetch_array()){
                ?>

                <h1 id="itemName" class="title"><?php echo"{$row['assetName']}";?></h1>
                <span>Asset ID: <?php echo $row['assetID'];?></span>

                <div class="row w3-light-grey w3-container w3-card-4 " id="ItemPanel">
                    <div class="col-9 w3-center " id="itemPicContainer">
                        <img src="<?php echo $row['imagepath'];?>" alt="Item Image" class="itemPicBig">
                    </div>

                    <div class="col-3" id="add-to-cart">
                        <form name="add_cart" action="add_to_cart.php" method="post">
                            <div id="qty">
                                <span style="color: black">Quantity: </span>
                                <input type="number" class="w3-input w3-border" style="width: 10em;" name="quantity" value="1" max="<?php echo"{$row['total_stock']}";?>" maxlength="6" size="4" />
                            </div>
                            <div class="buttonAddToCart">
                                <input type="hidden" name="assetID" value="<?php echo $row['assetID'];?>" />
                                <input type="hidden" name="assetName" value="<?php echo"{$row['assetName']}";?>"/>
                                <p class="quantity-in-cart">Quantity in Stock: <?php echo $row['total_stock'];?></p>
                                <input type="submit" class="confirmation" value="Add to cart" />
                            </div>
                        </form>
                    </div>

                </div>

                <div class="row" id="itemDescription">
                    <article class="col-12">
                        <p><?php echo "{$row['assetDescription']}";?></p>

                    </article>
                </div>



                <?php
            }
            $result2->close();
            $db->close();
            ?>
        </div>
    </div>


</main>


<!-- Footer -->
<footer class="w3-container w3-light-grey">
    <p> Designed by Somto Eluwa</p>
</footer>
<!-- -->

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Add this item to cart? ')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>

</body>
</html>