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

include 'assets/functions/functions.php' ;
$category = $_GET['categoryID'];

	//THIS PAGE IS DESTINATION FOR ADMIN WHEN LOGGED IN AND TRYING TO ACCESS INDEX.PHP, AND WHEN CLICKING LINKS LEADING HERE
	//If no session exists, admin is sent to index.php

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

<header>
    <img id="logo" src="assets/images/logo.png" alt="Home logo">
    <h3 id="title">Arduino component booking system</h3>

    <nav >
        <ul class="topnav">
            <li>
                <a href="home.php"><i title="Home" class="fa fa-home" style="font-size:36px;color: #ac76af;"></i></a>
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
                    <a href="#"><?php echo $_SESSION['ad_firstname']; ?>'s Profile</a>
                    <a href="adminviewitems.php">Dashboard</a>
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

<!--Main Start -->
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



            <div id="content" class="col-10 col-m-10">
                <?php
                if ($_GET['categoryID']){
                    $sql_asset = "SELECT * FROM asset WHERE categoryID = '$category' ";
                }
                else{
                    $sql_asset = "SELECT * FROM asset";
                }

                $result2 =  $db->query($sql_asset);
                while ($row = $result2->fetch_array()){

                ?>

                    <article class="col-4 col-m-4 itemBox">
                        <div class="row">
                            <div class="col-12 col-m-12 itemPic">
                                <a href="item.php?assetID=<?php echo $row['assetID'];?>">
                                    <img src="<?php echo $row['image'];?>" alt="Yellow LED" width="229" height="182"/>
                                </a>
                            </div>
                            <div class="col-12 col-m-12">
                                <h4 class="productTitle"><a href="item.php?assetID=<?php echo $row['assetID'];?>"><?php echo $row['assetName'];?></a></h4>
                                <div class="listingDescription"><?php echo "{$row['assetDescription']}";?></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-m-6">
                                    <div class="priceinlist"><?php echo $row['quantity'];?> In Stock </div>
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
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p> Designed by Somto Eluwa</p>
    </footer>
    <!-- -->



</body>
</html>
