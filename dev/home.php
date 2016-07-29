<?php
/**
 * Created by PhpStorm.
 * User: Sommy B
 * Date: 7/6/2016
 * Time: 12:43 PM
 */
session_start();
if(!isset($_SESSION['ad_email'])){
    header("Location: index.php");
}

include 'functions/functions.php';

//THIS PAGE IS DESTINATION FOR ADMIN WHEN LOGGED IN AND TRYING TO ACCESS INDEX.PHP, AND WHEN CLICKING LINKS LEADING HERE
//If no session exists, admin is sent to index.php

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System</title>
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
        <h2 id="login_title" class="w3-xlarge">Arduino component booking system</h2>
    </div>
    <!-- Responsive Top navigation bar -->
    <nav>
        <ul class="w3-navbar w3-theme w3-large w3-border">

            <li><a href="home.php"><i title="home" class="fa fa-home w3-large"></i></a></li>
            <li><a href="#"><i class="fa fa-search w3-large" aria-hidden="true"></i></a></li>
            <li class="w3-dropdown-hover w3-right" id="profile">
                <a class="w3-hover-purple" href="#"><i class="fa fa-user w3-large" aria-hidden="true"></i><i class="fa fa-caret-down"></i></a>
                <div class="w3-dropdown-content w3-white w3-card-2">
                    <a href="#">My Profile</a>
                    <a href="adminviewitems.php">Dashboard</a>
                    <a href="logout.php">Sign out</a>
                </div>
            </li>
            <li class="w3-right">
                <a href="#"><i class="fa fa-shopping-cart w3-large"></i></a>
            </li>
        </ul>
    </nav>
</header>



<!-- Sub header

<div id="pageSubHeader">
    <div class="row">
        <div class="col-8 col-m-8">
            <div id="BreadCrumb">
                <a href="home.php">Home</a>&nbsp;&gt;&nbsp; All Components
            </div>
        </div>
        <div class="col-4 col-m-4">
        </div>
    </div>
</div>-->


<!--Main Start -->
<main class="row">


    <ul id="sidenavbar" class=" w3-ul w3-light-grey w3-hoverable col-2" >
        <!-- Navbar header-->
        <li><a href="home.php" class="w3-border-bottom"><h3>Components</h3></a></li>

        <!-- Navbar content from database (move PHP to functions at later time)-->

        <li><a href="home.php?assetCategory=Actuators">Actuators</a></li>
        <li><a href="home.php?assetCategory=Connectors">Connectors</a></li>
        <li><a href="home.php?assetCategory=LCD & Matrix">LCD & Matrix</a></li>
        <li><a href="home.php?assetCategory=Passive & Active">Passive & Active</a></li>
        <li><a href="home.php?assetCategory=Sensors">Sensors</a></li>
    </ul>

    <div id="content" class="col-10 w3-padding-row">
        <!--<h3>All Components</h3>-->


        <?php
        $category= $_GET['assetCategory'];
        if ($category){

            $sql_asset = "SELECT * FROM asset WHERE assetCategory = '$category' ";
        }
        else{
            $sql_asset = "SELECT * FROM asset";
        }

        $result2 =  $db->query($sql_asset);
        while ($row = $result2->fetch_array()){

            ?>



            <article class="col-4 itemBox  w3-container">
                <div class="row">
                    <div class="col-12 col-m-12 itemPic ">
                        <a class="w3-center " href="item.php?assetID=<?php echo $row['assetID'];?>">
                            <img src="<?php echo $row['imagepath'];?>" alt="Asset Image" width="229" height="182"/>
                        </a>
                    </div>
                    <div class="col-12 col-m-12">
                        <h6 class="productTitle"><a href="item.php?assetID=<?php echo $row['assetID'];?>"><?php echo $row['assetName'];?></a></h6>
                        <div class="listingDescription"><?php echo "{$row['assetDescription']}";?></div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-m-6">
                            <div class="priceinlist"><?php echo $row['total_stock'];?> In Stock </div>
                        </div>
                        <div class="col-6 col-m-6">
                            <form class="funkycart" name="cart_quantity" action="#" method="#" enctype="multipart/form-data">
                                <input type="hidden" name="assetID" value="<?php echo $row['assetID'];?>">
                                <input type="hidden" name="cart_quantity" value="1">
                                <input type="submit" value="Add to cart" class="button tiny-button expand addcart-button">
                            </form>
                        </div>
                    </div>
                </div>
            </article>


            <?php
        }
        $result2->close();
        $db->close();
        ?>




    </div>
    
</main>

<!-- Footer -->
<footer class="w3-container w3-light-grey">
    <p> Designed by Somto Eluwa</p>
</footer>
<!-- -->



</body>
</html>
