<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
// Start session
// Start session
session_start();
$role = $_SESSION['sess_userrole'];
$userid = $_SESSION['userid'];
if(!isset($_SESSION['sess_email']) && ($role!="user"|| $role!="admin")){
    header('Location: index.php?err=2');
}

// include Database connection
include 'functions/functions.php';

// Page title
$page_title ="Arduino component booking system";
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
    <link href='https://fonts.googleapis.com/css?family=Montserrat:700|Roboto:400' rel='stylesheet' type='text/css'>
</head>

<body class="w3-content">

<header class="w3-light-grey">
    <!-- top panel-->
    <div class="w3-container">
        <img id="logo" src="assets/images/Robert_Gordon_University_logo.svg.png" alt="Home logo" style="width:30%">
        <marquee><h2 id="login_title" class="w3-xlarge"><?php echo isset($page_title) ? $page_title : "Arduino component booking System"; ?></h2></marquee>
    </div>
    <!-- Responsive Top navigation bar -->
    <nav>
        <ul class="w3-navbar w3-theme w3-large w3-border">

            <li><a href="home.php"><i title="home" class="fa fa-home w3-large"></i></a></li>
            <li><a href="#"><i class="fa fa-search w3-large" aria-hidden="true"></i></a></li>
            <li class="w3-dropdown-hover w3-right" id="profile">
                <a class="w3-hover-purple" href="#"><i class="fa fa-user w3-large" aria-hidden="true"></i><i class="fa fa-caret-down"></i></a>
                <div class="w3-dropdown-content w3-white w3-card-2">
                    <a href="account.php?userid=<?php echo $_SESSION['userid']; ?> "><?php echo $_SESSION['sess_firstname'];?>'s Profile</a>
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


<!--Main Start -->
<main class="row">

    <ul id="sidenavbar" class=" w3-ul w3-container w3-card-2 w3-theme-l4  w3-hoverable col-2" >

        <!-- Navbar header-->
        <li><a href="home.php" class="w3-border-bottom"><h3>Components</h3></a></li>

        <!-- Navbar content -->
        <li><a href="home.php?assetCategory=Actuators">Actuators</a></li>
        <li><a href="home.php?assetCategory=Connectors">Connectors</a></li>
        <li><a href="home.php?assetCategory=LCD_Matrix">LCD & Matrix</a></li>
        <li><a href="home.php?assetCategory=Passive_Active">Passive & Active</a></li>
        <li><a href="home.php?assetCategory=Sensors">Sensors</a></li>
    </ul>

    <div id="content" class="col-10 w3-padding-row">
        <!--<h3>All Components</h3>-->
        <?php

        // to prevent undefined index notice

        $action = isset($_GET['action']) ? $_GET['action'] : "";
        $name = isset($_GET['assetName']) ? $_GET['assetName'] : "";
        $category= isset($_GET['assetCategory']) ? $_GET['assetCategory'] : "";

        //addtional params
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "1";



        if($action=='added'){

            echo "<div class='w3-container w3-section w3-green'>";
            echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            echo "<p><strong>{$name}</strong> was added to your cart!</p>";
            echo "</div>";
        }


        if($action=='exists'){

            echo "<div class='w3-container w3-section w3-red'>";
            echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            echo "<p><strong>{$name}</strong> already exists in your cart! </p>";
            echo "<p>Please Update cart from checkout.</p>";
            echo "</div>";
        }
        if($action=='edited'){

            echo "<div class='w3-container w3-section w3-green'>";
            echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            echo "<p>Your details were updated successfully</p>";
            echo "</div>";
        }


        if($action=='failed'){

            echo "<div class='w3-container w3-section w3-red'>";
            echo "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            echo "<p>Something went wrong!</p>";
            echo "</div>";
        }


        if ($category){

            $sql_asset = "SELECT * FROM asset WHERE assetCategory = '$category' ORDER BY assetID DESC";
        }
        else{
            $sql_asset = "SELECT * FROM asset";
        }

        $result2 =  $db->query($sql_asset);

        //If there are no items to display to customers or buyers, display a no item message to the screen and that's cool man
        if(mysqli_num_rows($result2) < 1)
        {
            ?>
            <div id="response" class="w3-container w3-card-2 " align="center">
                <div id="empty_category" align="left">
                    <p>No components in this category.</p>
                    <a href="home.php"><button class="w3-center"> Go to Homepage</button></a>
                </div>
            </div>
            <?php
        }
        else
        {
            //If there are items in the asset table in the database available, then get all these items and display them as shown below


            while ($row = $result2->fetch_array()) {

                ?>


                <article class="col-4 itemBox w3-margin-bottom  w3-container ">
                    <div class="row">
                        <div class="col-12 col-m-12 itemPic w3-card-4  w3-center ">
                            <a class="w3-margin-right " href="item.php?assetID=<?php echo $row['assetID']; ?>">
                                <img src="<?php echo $row['imagepath']; ?>" alt="Asset Image" width="200"
                                     height="182"/>
                            </a>
                            <a href="item.php?assetID=<?php echo $row['assetID']; ?>">
                                <h6 class="productTitle test2" style="font-family: 'Montserrat', sans-serif; font-weight: 700;">
                                    <?php echo $row['assetName']; ?>
                                </h6>
                            </a>
                            <p class="listingDescription test2"><?php echo "{$row['assetDescription']}"; ?></p>
                            <a href="item.php?assetID=<?php echo $row['assetID'];?>"><button class="w3-btn w3-theme" style="width: 100%">
                                    View Details
                                </button></a>
                        </div>
                        <!--<div class="col-12 col-m-12">


                        </div>-->
                        <div class="row">
                            <!-- <div class="col-6 col-m-6">
                                    <div class="stock_count"><strong><?php /*echo $row['total_stock']; */?></strong> In Stock</div>
                                </div>-->
                            <div class="col-12">
                                <!-- <a href="add_to_cart.php?assetID=<?php /*echo $row['assetID'];*/?>&assetName=<?php /*echo $row['assetName'];*/?>&quantity=1"><button class="w3-btn w3-theme" id="add_to_cart_button" value="Add to Cart" title="Add this item to cart">
                                        Add to cart
                                    </button></a>-->


                            </div>
                        </div>
                    </div>
                </article>
                <?php

            }
        }
        ?>
    </div>




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

</body>
</html>
