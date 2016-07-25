<?php


session_start();
$username = $_SESSION["ad_firstname"];
if(!isset($_SESSION['ad_email'])){
    header("Location: adminviewitems.php");
}

include 'assets/functions/functions.php' ;
$assetID = $_GET['assetID'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Arduino Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
</head>

<body>
    <!-- Header start -->
    <header>
        <img id="logo" src="/dev/assets/images/logo.png" alt="Home logo">
        <h3 id="title">Arduino component booking system</h3>

        <nav >
            <ul class="topnav">
                <li>
                    <a href="index.php"><i title="Home" class="fa fa-home" style="font-size:36px;color: #ac76af;"></i></a>
                </li>
                <li>
                    <form action="#" class="navSearch">
                        <i class="fa fa-search" aria-hidden="true" style="color:#ac76af"></i>
                        <input type="search" name="componentsearch"  placeholder="Search here ...">

                        <select title="searchCategories"">
                        <?php
                        $sql_search = "SELECT categoryID,categoryName FROM category";
                        $result_search = $db->query($sql_search);
                        if(mysqli_num_rows($result_search)>0){
                            $counter=0;

                            while($row_search = $result_search->fetch_array()){

                                ?>
                                <option value="<?php echo $row_search['categoryID'];?>"><?php echo $row_search['categoryName'];?></option>
                                <?
                            }

                        }
                        $result_search->close()

                        ?>
                        <input type="submit" name="search" id="search">
                    </form>
                </li>
                <li class="dropdown right" id="profile">
                    <a class="dropbtn" href="#"><i class="fa fa-user" aria-hidden="true" style="font-size:36px;color:#ac76af"></i></a>
                    <div class="dropdown-content">
                        <a href="#"><?php echo "{$username}"?>'s Profile</a>
                        <a href="admin.php">Dashboard</a>
                        <a href="logout.php">Sign out</a>
                    </div>
                </li>
                <li class="right">
                    <a href="#"><i class="fa fa-shopping-cart" style="font-size:36px;color:#ac76af"></i></a>
                </li>

            </ul>
        </nav>
    </header>


    <!-- Sub header -->

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
    </div>

    <!-- Main Start Item details -->
    <main>
        <div class="row">
            <div id="sidenavbar" class="col-2 col-m-2 menu">
                <section>
                    <p class="title">
                        <a href="#">Components</a>
                    </p>

                    <div class="content">
                        <?php
                        //$category = $_GET['categoryID'];
                        $sql_catNav = "SELECT * FROM category";
                        $result =  $db->query($sql_catNav);

                        if(mysqli_num_rows($result)>0){
                            $counter = 0;
                            while ($row = $result->fetch_array())
                            {
                                $counter++;
                                ?>
                                <ul class="side-nav">
                                    <li><a href="home.php?categoryID=<?php echo $row['categoryID'];?>"><?php echo "{$row['categoryName']}";?></a></li>
                                </ul>
                                <?php
                            }
                        }
                        $result->close();

                        ?>
                    </div>
                </section>
            </div>

            <div id="itemdetails" class="col-10 col-m-10">
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

                <div class="row" id="ItemPanel">
                    <div class="col-9" id="itemPicContainer">
                        <img src="<?php echo $row['image'];?>" alt="Item Image" class="itemPicBig">
                    </div>

                    <div class="col-3" id="ItemCheckoutOptions">
                        <form name="add_cart" action="#" method="post">
                            <div id="qty">
                                <span style="color: black">Quantity: </span><input type="number" name="cart_quantity" value="1" maxlength="6" size="4" />
                            </div>
                            <div class="buttonAddToCart">
                                <input type="hidden" name="asset_id" value="<?php echo $row['assetID'];?>" />
                                <p class="quantity-in-cart">Quantity in Stock: <?php echo $row['quantity'];?></p>
                                <input type="submit" class="button small-button cart-button expand" value="Add to cart" />
                            </div>
                        </form>
                    </div>
            <div class="row" id="itemDescription">
                <article class="col-12">
                    <p><?php echo "{$row['assetDescription']}";?></p>

                </article>
            </div>

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
    <footer style="background-color: purple">
        <p> Designed by Somto Eluwa</p>
    </footer>
    <!-- -->




</body>
</html>